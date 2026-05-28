<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    public const ACCESS_ALL = 'all';
    public const ACCESS_ADMIN = 'admin';
    public const ACCESS_MANAGER = 'manager';
    public const ACCESS_STAFF_ADMIN = 'staff-admin';

    protected $fillable = [
        'nama_dokumen',
        'deskripsi_dokumen',
        'nama_file',
        'file_path',
        'ukuran_file',
        'role_akses_dokumen',
        'created_by',
        'updated_by',
    ];

    public function setRoleAksesDokumenAttribute($value): void
    {
        if (is_array($value)) {
            $roles = array_values(array_unique(array_filter($value, fn ($role) => trim((string) $role) !== '')));

            $this->attributes['role_akses_dokumen'] = json_encode($roles ?: [self::ACCESS_ALL]);

            return;
        }

        $this->attributes['role_akses_dokumen'] = trim((string) $value) ?: self::ACCESS_ALL;
    }

    public static function adminRoles(): array
    {
        return ['admin'];
    }

    public static function managerRoles(): array
    {
        return [
            'head of airport service',
            'spv apron',
            'spv bge',
            'spv',
            'ass leader',
            'ass leader apron',
            'ass leader bge',
            'leader',
            'leader apron',
            'leader bge',
            'leader porter apron',
            'leader aircraft interior exterior cleaning',
        ];
    }

    public static function staffRoles(): array
    {
        return [
            'aircraft interior exterior cleaning',
            'controller',
            'dispatcher',
            'driver',
            'finance',
            'hse',
            'porter',
            'porter apron',
            'porter bge',
            'quality control',
        ];
    }

    public static function normalizeRole(?string $role): string
    {
        return strtolower(trim((string) $role));
    }

    public function scopeVisibleForRole(Builder $query, ?string $role): Builder
    {
        return $query->where(function ($q) use ($role) {
            $q->where('role_akses_dokumen', self::ACCESS_ALL)
                ->orWhere('role_akses_dokumen', 'like', '%"all"%')
                ->orWhere('role_akses_dokumen', 'like', '%' . trim((string) $role) . '%');
        });
    }

    public function getRoleAccessValuesAttribute(): array
    {
        $access = $this->attributes['role_akses_dokumen'] ?? self::ACCESS_ALL;
        $decodedAccess = json_decode((string) $access, true);

        if (is_array($decodedAccess)) {
            return array_values(array_unique(array_filter($decodedAccess, fn ($role) => trim((string) $role) !== '')));
        }

        return self::legacyAccessToRoles((string) $access);
    }

    public function isVisibleForRole(?string $role): bool
    {
        if ($this->isAllRoleAccess()) {
            return true;
        }

        return in_array(
            self::normalizeRole($role),
            $this->normalizedRoleAccessValues(),
            true
        );
    }

    public function isAllRoleAccess(): bool
    {
        return in_array(self::ACCESS_ALL, $this->normalizedRoleAccessValues(), true);
    }

    public function hasRoleAccess(?string $role, bool $includeAll = false): bool
    {
        if ($this->isAllRoleAccess()) {
            return $includeAll;
        }

        return in_array(self::normalizeRole($role), $this->normalizedRoleAccessValues(), true);
    }

    public function hasAnyRoleAccess(array $roles, bool $includeAll = false): bool
    {
        if ($this->isAllRoleAccess()) {
            return $includeAll;
        }

        return collect($roles)
            ->map(fn ($role) => self::normalizeRole($role))
            ->intersect($this->normalizedRoleAccessValues())
            ->isNotEmpty();
    }

    public function getAccessLabelAttribute(): string
    {
        if ($this->isAllRoleAccess()) {
            return 'Akses: Semua Role';
        }

        $roles = $this->role_access_values;
        if (count($roles) > 2) {
            return 'Akses: ' . count($roles) . ' Role';
        }

        $shownRoles = array_slice($roles, 0, 2);
        $label = implode(', ', $shownRoles);
        $remainingRoles = count($roles) - count($shownRoles);

        if ($remainingRoles > 0) {
            $label .= ' +' . $remainingRoles . ' role';
        }

        return 'Akses: ' . $label;
    }

    public function getAccessFullLabelAttribute(): string
    {
        if ($this->isAllRoleAccess()) {
            return 'Akses: Semua Role';
        }

        return 'Akses: ' . implode(', ', $this->role_access_values);
    }

    public function getAccessClassAttribute(): string
    {
        if ($this->isAllRoleAccess()) {
            return 'is-all';
        }

        if ($this->hasRoleAccess('Admin')) {
            return 'is-admin';
        }

        if ($this->hasAnyRoleAccess(self::managerRoles())) {
            return 'is-manager';
        }

        return 'is-staff-admin';
    }

    private static function legacyAccessToRoles(string $access): array
    {
        return match (self::normalizeRole($access)) {
            self::ACCESS_ALL => [self::ACCESS_ALL],
            self::ACCESS_ADMIN => ['Admin'],
            self::ACCESS_MANAGER => self::titleRoles(self::managerRoles()),
            self::ACCESS_STAFF_ADMIN => array_merge(['Admin'], self::titleRoles(self::staffRoles())),
            default => [$access],
        };
    }

    private static function titleRoles(array $roles): array
    {
        return collect($roles)
            ->map(fn ($role) => collect(explode(' ', $role))
                ->map(fn ($word) => strlen($word) <= 3 ? strtoupper($word) : ucfirst($word))
                ->implode(' '))
            ->values()
            ->all();
    }

    private function normalizedRoleAccessValues(): array
    {
        return collect($this->role_access_values)
            ->map(fn ($role) => self::normalizeRole($role))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

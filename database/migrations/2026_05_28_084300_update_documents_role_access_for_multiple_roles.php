<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropIndex(['role_akses_dokumen']);
        });

        DB::statement('ALTER TABLE documents MODIFY role_akses_dokumen TEXT NOT NULL');

        $userRoles = DB::table('users')
            ->whereNotNull('role')
            ->distinct()
            ->pluck('role')
            ->filter()
            ->values();

        $rolesByNormalized = $userRoles
            ->mapWithKeys(fn ($role) => [$this->normalizeRole($role) => $role])
            ->all();

        $managerRoles = [
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

        $staffRoles = [
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

        DB::table('documents')
            ->select('id', 'role_akses_dokumen')
            ->orderBy('id')
            ->get()
            ->each(function ($document) use ($rolesByNormalized, $managerRoles, $staffRoles) {
                $currentAccess = trim((string) $document->role_akses_dokumen);
                $decodedAccess = json_decode($currentAccess, true);

                if (is_array($decodedAccess)) {
                    return;
                }

                $normalizedAccess = $this->normalizeRole($currentAccess);
                $nextAccess = match ($normalizedAccess) {
                    'all' => ['all'],
                    'admin' => [$rolesByNormalized['admin'] ?? 'Admin'],
                    'manager' => $this->resolveRoles($managerRoles, $rolesByNormalized),
                    'staff-admin' => array_merge(
                        [$rolesByNormalized['admin'] ?? 'Admin'],
                        $this->resolveRoles($staffRoles, $rolesByNormalized)
                    ),
                    default => [$currentAccess],
                };

                $nextAccess = array_values(array_unique(array_filter($nextAccess)));

                DB::table('documents')
                    ->where('id', $document->id)
                    ->update([
                        'role_akses_dokumen' => json_encode($nextAccess ?: ['all']),
                    ]);
            });
    }

    public function down(): void
    {
        DB::table('documents')->update([
            'role_akses_dokumen' => 'all',
        ]);

        DB::statement("ALTER TABLE documents MODIFY role_akses_dokumen VARCHAR(50) NOT NULL DEFAULT 'all'");

        Schema::table('documents', function (Blueprint $table) {
            $table->index('role_akses_dokumen');
        });
    }

    private function normalizeRole(?string $role): string
    {
        return strtolower(trim((string) $role));
    }

    private function resolveRoles(array $roles, array $rolesByNormalized): array
    {
        return collect($roles)
            ->map(fn ($role) => $rolesByNormalized[$this->normalizeRole($role)] ?? null)
            ->filter()
            ->values()
            ->all();
    }
};

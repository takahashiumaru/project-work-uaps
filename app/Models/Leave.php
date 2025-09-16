<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'attachment_path',
        'replacement_employee_name',
        'status',
        'approved_by', // Ini untuk Head Office (final approver)
        'approved_at',
        'rejected_by',
        'manager_comment',
        'pic_approved_by', // DITAMBAHKAN: ID PIC yang menyetujui
        'pic_approved_at', // DITAMBAHKAN: Waktu PIC menyetujui
    ];

    /**
     * Relasi ke user yang mengajukan cuti.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * DITAMBAHKAN: Relasi ke user PIC yang menyetujui.
     */
    public function picApprover()
    {
        return $this->belongsTo(User::class, 'pic_approved_by');
    }

    /**
     * Relasi ke user Head Office yang menyetujui.
     * Nama 'approvedBy' diganti menjadi 'hoApprover' agar lebih jelas.
     */
    public function hoApprover()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relasi ke user yang menolak.
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // Accessor Anda untuk total_days sudah bagus.
    public function getTotalDaysAttribute($value)
    {
        if ($value !== null) {
            return (int) $value;
        }

        if ($this->start_date && $this->end_date) {
            return Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)) + 1;
        }

        return 0;
    }
}
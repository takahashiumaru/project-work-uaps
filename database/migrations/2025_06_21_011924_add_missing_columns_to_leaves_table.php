<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            // Tambahkan kolom baru jika belum ada
            // Pastikan tipe data sesuai dengan kebutuhan Anda
            // total_days menggantikan number_of_days
            if (!Schema::hasColumn('leaves', 'total_days')) {
                $table->integer('total_days')->nullable()->after('end_date');
            }
            // attachment_path menggantikan document
            if (!Schema::hasColumn('leaves', 'attachment_path')) {
                $table->string('attachment_path')->nullable()->after('reason');
            }
            if (!Schema::hasColumn('leaves', 'replacement_employee_name')) {
                $table->string('replacement_employee_name')->nullable()->after('attachment_path');
            }
            if (!Schema::hasColumn('leaves', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users');
            }
            if (!Schema::hasColumn('leaves', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (!Schema::hasColumn('leaves', 'rejected_by')) {
                $table->foreignId('rejected_by')->nullable()->constrained('users');
            }
            if (!Schema::hasColumn('leaves', 'manager_comment')) {
                $table->text('manager_comment')->nullable()->after('rejected_by');
            }

            // Opsional: Jika kolom lama seperti 'description' atau 'document' sudah tidak terpakai,
            // Anda bisa menghapusnya di sini. HATI-HATI: Ini akan menghapus data yang ada.
            // if (Schema::hasColumn('leaves', 'description')) {
            //     $table->dropColumn('description');
            // }
            // if (Schema::hasColumn('leaves', 'document')) {
            //     $table->dropColumn('document');
            // }
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            // Balikkan perubahan di metode down
            $table->dropColumn([
                'total_days',
                'attachment_path',
                'replacement_employee_name',
                'approved_by',
                'approved_at',
                'rejected_by',
                'manager_comment'
            ]);

            // Opsional: Jika Anda menghapus kolom di up(), tambahkan kembali di sini untuk rollback
            // $table->text('description')->nullable();
            // $table->string('document')->nullable();
        });
    }
};
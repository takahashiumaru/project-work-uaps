<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Shift;
use App\Models\Station;
use App\Models\User;
use Tests\TestCase;

class AdminMenuSmokeTest extends TestCase
{
    public function test_admin_menu_pages_render_without_server_errors(): void
    {
        $admin = User::where('role', 'Admin')->firstOrFail();
        $sampleUser = User::orderBy('id')->firstOrFail();

        $routes = [
            'Dashboard' => route('home'),
            'Profile' => route('users.profile', $admin->id),
            'Jadwal Hari Ini' => route('schedule.now'),
            'Data Schedule' => route('schedule.index'),
            'Create Update Schedule' => route('schedule.view'),
            'Schedule Freelance' => route('schedule.freelances'),
            'Tambah Freelance' => route('freelance.create'),
            'Shift' => route('shift.index'),
            'Shift Create' => route('shift.create'),
            'Absensi Hari Ini' => route('attendance.index'),
            'Absensi Camera In' => route('attendance.camera', ['type' => 'in']),
            'Absensi Camera Out' => route('attendance.camera', ['type' => 'out']),
            'Riwayat Absensi' => route('attendance.history'),
            'Laporan Absensi' => route('attendance.reports'),
            'Lembur Saya' => route('overtime.index'),
            'Tambah Lembur' => route('overtime.create'),
            'Approval Lembur' => route('overtime.approval'),
            'Laporan Lembur' => route('overtime.report'),
            'Manajemen Station' => route('stations.index'),
            'Station Baru' => route('stations.create'),
            'Monitor Station' => route('staff.index'),
            'Blacklist' => route('blacklist.index'),
            'Kontrak' => route('users.kontrak'),
            'Kontrak Edit' => route('users.KontrakEdit', $sampleUser->id),
            'PAS Bandara' => route('users.pas'),
            'PAS Edit' => route('users.PASEdit', $sampleUser->id),
            'TIM Bandara' => route('users.tim'),
            'TIM Edit' => route('users.TIMEdit', $sampleUser->id),
            'Users Lama' => route('users.index'),
            'Users Apron' => route('users.apron'),
            'Users BGE' => route('users.bge'),
            'Users Office' => route('users.office'),
            'Tambah Staff' => route('users.create'),
            'User Detail' => route('users.show', $sampleUser->id),
            'User Edit' => route('users.edit', $sampleUser->id),
            'Dokumen' => route('document'),
            'Flights' => route('flights.index'),
            'Manajemen Training' => route('admin.training.certificates.index'),
            'Tambah Sertifikat' => route('admin.training.certificates.create'),
            'Sertifikat Saya' => route('my.certificates'),
            'Pengajuan Leave' => route('leaves.pengajuan'),
            'Form Leave' => route('leaves.create'),
            'Approval Leave' => route('leaves.index'),
            'Laporan Leave' => route('leaves.laporan'),
            'FAQ' => route('faq'),
            'Kebijakan Privasi' => route('kebijakan'),
        ];

        if ($station = Station::orderBy('id')->first()) {
            $routes['Station Edit'] = route('stations.edit', $station->id);
        }

        if ($shift = Shift::orderBy('id')->first()) {
            $routes['Shift Edit'] = route('shift.edit', $shift->id);
        }

        if ($certificate = Certificate::orderBy('id')->first()) {
            $routes['Training Edit'] = route('admin.training.certificates.edit', $certificate->id);
        }

        foreach ($routes as $label => $url) {
            $response = $this->actingAs($admin)->get($url);

            $this->assertLessThan(
                500,
                $response->getStatusCode(),
                "{$label} returned HTTP {$response->getStatusCode()} for {$url}"
            );
        }
    }
}

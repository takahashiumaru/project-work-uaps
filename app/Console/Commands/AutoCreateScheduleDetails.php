<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\schedule_detail;
use App\Models\User;

class AutoCreateScheduleDetails extends Command
{
    protected $signature = 'schedule:autocreate';
    protected $description = 'Auto-create schedule details once per day';

    public function handle()
    {
        $allUsers = User::where('role', 'PORTER')->orderBy('id')->get();
        $userIndex = 0;

        $schedules = Schedule::all();

        foreach ($schedules as $schedule) {
            $existingUserIds = schedule_detail::where('schedule_id', $schedule->id)->pluck('user_id')->toArray();
            $existingCount = count($existingUserIds);

            $needed = $schedule->use - $existingCount;

            for ($i = 0; $i < $needed && $userIndex < count($allUsers); $i++) {
                $user = $allUsers[$userIndex];

                schedule_detail::firstOrCreate([
                    'schedule_id' => $schedule->id,
                    'user_id' => $user->id
                ]);

                $userIndex++;
            }
        }

        $this->info('Schedule details successfully distributed without duplicate users.');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateScheduleStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update donation schedule status based on start and end time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();

        // Update upcoming -> ongoing
        $upcomingUpdated = \App\Models\DonationSchedule::where('status', 'upcoming')
            ->where('start_time', '<=', $now)
            ->update(['status' => 'ongoing']);

        // Update ongoing -> completed
        $ongoingUpdated = \App\Models\DonationSchedule::where('status', 'ongoing')
            ->where('end_time', '<=', $now)
            ->update(['status' => 'completed']);

        $this->info("Updated {$upcomingUpdated} schedules to ongoing, and {$ongoingUpdated} schedules to completed.");

        return 0;
    }
}

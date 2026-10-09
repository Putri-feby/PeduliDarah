<?php

namespace App\Console\Commands;

use App\Models\DonationSchedule;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateExpiredSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of expired donation schedules';

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
        $updated = DonationSchedule::where('end_time', '<', Carbon::now())
            ->where('status', '!=', 'expired')
            ->update(['status' => 'expired']);

        $this->info("Updated {$updated} expired schedule(s).");

        return 0;
    }
}

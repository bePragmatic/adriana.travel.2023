<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronController;
use App\Http\Helper\PaymentHelper;
use Illuminate\Console\Command;

class ical_sync extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ical:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs iCal Calendars';

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
     * @return mixed
     */
    public function handle()
    {
        $cron = new CronController(new PaymentHelper());

        $cron->ical_sync();

        $this->comment(PHP_EOL . 'Calendars Synced' . PHP_EOL);
    }
}

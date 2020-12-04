<?php

namespace App\Console\Commands;

use App\Api\V1\Services\NewAdvertSMSSenderService;
use Illuminate\Console\Command;

class NewAdvertSMSSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newAdvert:SMS';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send SMS for drivers if a new advert is found.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $newAdvertSMS;
    public function __construct(NewAdvertSMSSenderService $newAdvertSMS)
    {
        parent::__construct();
        $this->newAdvertSMS = $newAdvertSMS;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->newAdvertSMS->send();
    }
}

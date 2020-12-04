<?php

namespace App\Console\Commands;

use App\Api\V1\Services\DateToDateAdvertSMSSender;
use Illuminate\Console\Command;

class AdvertDateToDateSMSSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'date2dateAdvertSender:advertSender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send every days advert view for advertisers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $dateToDateAdvertSender;
    public function __construct(DateToDateAdvertSMSSender $dateToDateAdvertSMSSender)
    {
        parent::__construct();
        $this->dateToDateAdvertSender =$dateToDateAdvertSMSSender;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->dateToDateAdvertSender->send();
    }
}

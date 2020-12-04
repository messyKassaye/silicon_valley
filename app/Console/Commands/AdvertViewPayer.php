<?php

namespace App\Console\Commands;

use App\Api\V1\Services\CarAdvertViewPayment;
use Illuminate\Console\Command;
use Auth;
class AdvertViewPayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:payer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is prepared to pay drivers advert view and tab adverts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $carAdvertViewPayment;
    public function __construct(CarAdvertViewPayment $carAdvertViewPayment)
    {
        parent::__construct();
        $this->carAdvertViewPayment = $carAdvertViewPayment;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->carAdvertViewPayment->pay();
    }
}

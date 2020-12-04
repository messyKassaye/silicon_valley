<?php

namespace App\Console\Commands;

use App\Api\V1\Services\CheckAdvertCompletions;
use Illuminate\Console\Command;

class AdvertCompletionChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advert:completer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $checkCompletion;
    public function __construct(CheckAdvertCompletions $checker)
    {
        parent::__construct();
        $this->checkCompletion = $checker;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->checkCompletion->check();
    }
}

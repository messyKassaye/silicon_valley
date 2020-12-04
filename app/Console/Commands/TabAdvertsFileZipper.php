<?php

namespace App\Console\Commands;

use App\Api\V1\Services\FileZipperService;
use Illuminate\Console\Command;

class TabAdvertsFileZipper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:zipper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to create zip files of our adverts data for driver and downloader';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $fileZipperServices;
    public function __construct(FileZipperService $fileZipperService)
    {
        parent::__construct();
        $this->fileZipperServices = $fileZipperService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
       $this->fileZipperServices->startZipping();
    }
}

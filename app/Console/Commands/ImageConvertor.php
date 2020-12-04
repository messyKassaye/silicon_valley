<?php

namespace App\Console\Commands;

use App\Api\V1\Services\ImageConverterService;
use Illuminate\Console\Command;

class ImageConvertor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:converter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will convert base64 image into real image';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $imageConverterService;
    public function __construct(ImageConverterService $imageConverterService)
    {
        parent::__construct();
        $this->imageConverterService = $imageConverterService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->imageConverterService->startConverting();
    }
}

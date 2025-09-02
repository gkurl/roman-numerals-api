<?php

namespace App\Console\Commands;

use App\Services\ConversionService;
use Illuminate\Console\Command;

class ConvertInteger extends Command
{

    public function __construct(
       protected ConversionService $conversionService
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roman:convert {integer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts a number between 1-3999 to a roman numerical representation of it';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $numberInput = $this->ask('Please enter a number between 1-3999)');
        $output = $this->conversionService->convertAndRecord($numberInput);
        $this->info('Your number was: ' . $numberInput . ' ' . 'In roman this is .' . $output);
    }
}

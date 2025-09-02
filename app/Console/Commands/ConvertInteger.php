<?php

namespace App\Console\Commands;

use App\Services\ConversionService;
use Illuminate\Console\Command;
use App\Validation\ConversionValidationRules;
use Illuminate\Support\Facades\Validator;

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
       $input = $this->argument('integer') ?? $this->ask('Enter your number (1-3999)');

       $validator = Validator::make(
           ['integer' => $input],
           ConversionValidationRules::rules(),
           ConversionValidationRules::messages()
       );

       if ($validator->fails()) {
           $this->error('Invalid input: ' . $validator->errors()->first('integer'));
           return 1;
       }

       try {
           $integer = (int) $validator->validated()['integer'];
           $convertedInteger = $this->conversionService->convertAndRecord($integer);
           $this->info("$integer -> $convertedInteger");
       } catch (\Exception $e) {
            $this->error('Invalid input: ' . $e->getMessage());
       }

       return 0;
    }
}

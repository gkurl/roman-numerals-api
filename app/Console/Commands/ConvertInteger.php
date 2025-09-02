<?php

namespace App\Console\Commands;

use App\Services\ConversionServiceInterface;
use Illuminate\Console\Command;
use App\Validation\ConversionValidationRules;
use Illuminate\Support\Facades\Validator;

class ConvertInteger extends Command
{

    public function __construct(
       protected ConversionServiceInterface $conversionService
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
    public function handle(): int
    {
       $input = $this->argument('integer');

       $validator = Validator::make(
           ['integer' => $input],
           ConversionValidationRules::rules(),
           ConversionValidationRules::messages()
       );

       if ($validator->fails()) {
           $this->error('Conversion Failed: ' . $validator->errors()->first('integer'));
           return 1;
       }

       try {
           $integer = (int) $validator->validated()['integer'];
           $convertedInteger = $this->conversionService->convertAndRecord($integer);
           $this->info("Converted {$integer} to Roman: {$convertedInteger->roman}");
       } catch (\Exception $e) {
            $this->error('Conversion Failed: ' . $e->getMessage());
       }

       return 0;
    }
}

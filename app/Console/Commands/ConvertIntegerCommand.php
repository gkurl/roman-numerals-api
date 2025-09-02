<?php

namespace App\Console\Commands;

use App\Services\ConversionServiceInterface;
use Illuminate\Console\Command;
use App\Validation\ConversionValidationRules;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ConvertIntegerCommand extends Command
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
        Log::withContext([
            'correlation_id' => (string) Str::uuid(),
            'cli' => true,
        ]);

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

           Log::channel('conversions')->info('cli.conversion_success', [
               'integer' => $integer,
               'roman' => $convertedInteger->roman,
           ]);

       } catch (\Throwable $e) {
           Log::channel('conversions')->error('cli.conversion_failed', [
               'integer' => $integer,
               'error' => $e->getMessage(),
           ]);

            $this->error('Conversion Failed: ' . $e->getMessage());
            return 1;
       }
       return 0;
    }
}

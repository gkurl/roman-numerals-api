<?php

namespace App\Services;

use App\Models\ConversionStat;
use App\Repositories\ConversionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

//Could also be a 'final' class if not extended elsewhere
class ConversionService implements ConversionServiceInterface
{
    public function __construct(
        protected IntegerConverterInterface $romanNumeralConverter,
        protected ConversionRepositoryInterface $conversionRepository,
    ) {}

    /**
     * @throws Throwable
     */
    public function convertAndRecord(int $integer): ConversionStat {

        $roman = $this->romanNumeralConverter->convertInteger($integer);
        $now = Carbon::now();

        try {
            $convertedOutput = $this->conversionRepository->upsertOrIncrement($integer, $roman, $now);

            Log::channel('conversions')->info('conversion.recorded', [
                'user_id' => optional(auth()->user())->id,
                'integer' => $integer,
                'roman' => $roman,
                'conversions_count' => $convertedOutput->conversions_count,
                'last_converted_at' => $convertedOutput->last_converted_at?->toIso8601String(),
                'correlation_id' => request()?->attributes->get('correlation_id'),
            ]);

            return $convertedOutput;
        } catch(Throwable $e) {
            Log::channel('conversions')->error('conversion.failed', [
                'user_id' => optional(auth()->user())->id,
                'integer' => $integer,
                'roman' => $roman,
                'error' => $e->getMessage(),
                'correlation_id' => request()?->attributes->get('correlation_id'),
            ]);
            throw $e; //Re-throw after logging in-case controllers/commands don't catch it
        }
    }

    public function findTop(int $limit): Collection {
        return $this->conversionRepository->findTop($limit);
    }

    public function findRecent(int $limit): Collection {
        return $this->conversionRepository->findRecent($limit);
    }

}

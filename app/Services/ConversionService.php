<?php

namespace App\Services;

use App\Models\ConversionStat;
use App\Repositories\ConversionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

//Could also be a 'final' class if not extended elsewhere
class ConversionService implements ConversionServiceInterface
{
    public function __construct(
        protected IntegerConverterInterface $romanNumeralConverter,
        protected ConversionRepositoryInterface $conversionRepository,
    ) {}

    public function convertAndRecord(int $integer): ConversionStat {

        $roman = $this->romanNumeralConverter->convertInteger($integer);
        $now = Carbon::now();

        return $this->conversionRepository->upsertOrIncrement($integer, $roman, $now);
    }

    public function findTop(int $limit): Collection {
        return $this->conversionRepository->findTop($limit);
    }

    public function findRecent(int $limit): Collection {
        return $this->conversionRepository->findRecent($limit);
    }

}

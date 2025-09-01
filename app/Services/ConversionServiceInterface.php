<?php

namespace App\Services;

use App\Models\ConversionStat;
use Illuminate\Database\Eloquent\Collection;

interface ConversionServiceInterface
{
    public function convertAndRecord(int $integer): ConversionStat;
    public function findTop(int $limit): Collection;
    public function findRecent(int $limit): Collection;
}

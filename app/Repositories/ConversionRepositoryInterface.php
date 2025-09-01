<?php

namespace App\Repositories;

use App\Models\ConversionStat;
use Illuminate\Database\Eloquent\Collection;

interface ConversionRepositoryInterface {

    public function upsertOrIncrement (int $integer, String $roman, \DateTime $now) : ConversionStat;

    public function findTop(int $limit = 10): Collection;

    public function findRecent(int $limit = 10): Collection;
}

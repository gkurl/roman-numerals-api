<?php

namespace App\Repositories;

use App\Models\ConversionStat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConversionRepository implements ConversionRepositoryInterface
{

    // Thought about maybe using DI here

//    protected ConversionStat $conversionStat;
//
//    public function __construct(ConversionStat $conversionStat) {
//        $this->conversionStat = $conversionStat;
//    }


    // Went for singular atomic operation instead
    public function upsertOrIncrement(int $integer, String $roman, \DateTime $now) : ConversionStat {

        Log::channel('conversions')->debug('upsertOrIncrement called', [
            'integer' => $integer,
            'roman' => $roman,
        ]);

        DB::table('conversion_stats')->upsert(
            [
                'integer_value' => $integer,
                'roman' => $roman,
                'conversions_count' => 1,
                'last_converted_at' => $now,
                'updated_at' => $now,
                'created_at' => $now,
            ],
            ['integer_value'],
            ['roman', 'conversions_count' => DB::raw('conversions_count + 1'),
                'last_converted_at' => $now,
                'updated_at' => $now
            ]
        );

        // returning model here but did consider using the DTO approach as well
        // OR ConversionStat::where instead of query, I suppose
        return ConversionStat::query()->where('integer_value', $integer)->first();
    }

    public function findTop(int $limit = 10): Collection {

        return ConversionStat::query()->orderByDesc('conversions_count')->orderByDesc('last_converted_at')
            ->limit($limit)->get();
    }

    public function findRecent(int $limit = 10): Collection {

        return ConversionStat::query()->orderByDesc('last_converted_at')->limit($limit)->get();
    }

}

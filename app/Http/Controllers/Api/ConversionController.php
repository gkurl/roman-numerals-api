<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversionRequest;
use App\Http\Requests\StatsRequest;
use App\Http\Resources\ConversionResource;
use App\Services\ConversionServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class ConversionController extends Controller
{

    public function __construct(
        protected ConversionServiceInterface $conversionService
    ){}

    //not sure if $request->integer is valid yet as command not written fully yet
    public function convert(ConversionRequest $request): ConversionResource
    {
        Log::channel('conversions')->info('api.convert_called', [
            'user_id' => $request->user()?->id,
            'integer' => $request->input('integer'),
            'ip' => $request->ip(),
        ]);

        $convertedInteger = $this->conversionService->convertAndRecord($request->integer);
        return new ConversionResource($convertedInteger);
    }

    public function recent(StatsRequest $statsRequest): AnonymousResourceCollection
    {
        $limit = $statsRequest->validatedLimit();
        $recentConversions = $this->conversionService->findRecent($limit);
        return ConversionResource::collection($recentConversions);
    }

    public function top(StatsRequest $statsRequest): AnonymousResourceCollection
    {
        $limit = $statsRequest->validatedLimit();
        $topConversions = $this->conversionService->findTop($limit);
        return ConversionResource::collection($topConversions);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversionRequest;
use App\Http\Resources\ConversionResource;
use App\Services\ConversionService;

class ConversionController extends Controller
{

    protected ConversionService $conversionService;

    public function __construct(ConversionService $conversionService) {
        $this->conversionService = $conversionService;
    }

    //not sure if $request->integer is valid yet
    public function convert(ConversionRequest $request): ConversionResource
    {
        $convertedInteger = $this->conversionService->convertAndRecord($request->integer);
        return new ConversionResource($convertedInteger);
    }

    public function recent(ConversionRequest $request): ConversionResource
    {
        $recentConversions = $this->conversionService->findRecent($request->integer);
        return new ConversionResource($recentConversions);
    }

    public function top(ConversionRequest $request): ConversionResource
    {
        $topConversions = $this->conversionService->findTop($request->integer);
        return new ConversionResource($topConversions);
    }
}

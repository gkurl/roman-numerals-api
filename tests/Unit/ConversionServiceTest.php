<?php

namespace Tests\Unit;

use App\Http\Resources\ConversionResource;
use App\Models\ConversionStat;
use App\Repositories\ConversionRepositoryInterface;
use App\Services\ConversionService;
use App\Services\ConversionServiceInterface;
use App\Services\IntegerConverterInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Tests\TestCase;
class ConversionServiceTest extends TestCase
{
    public function test_convert_and_record_invokes_converter_and_repository(): void
    {
        $converter = $this->createMock(IntegerConverterInterface::class);
        $converter->expects($this->once())
            ->method('convertInteger')
            ->with(2016)
            ->willReturn('MMXVI');

        $model = new ConversionStat(['integer_value' => 2016, 'roman' => 'MMXVI', 'conversions_count' => 1]);

        $repo = $this->createMock(ConversionRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('upsertOrIncrement')
            ->with(
                2016,
                'MMXVI',
                $this->isInstanceOf(Carbon::class)
            )
            ->willReturn($model);

        $service = new ConversionService($converter, $repo);

        $result = $service->convertAndRecord(2016);

        $this->assertSame($model, $result);
    }
}

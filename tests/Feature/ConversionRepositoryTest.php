<?php

namespace Tests\Feature;

use App\Models\ConversionStat;
use App\Repositories\ConversionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ConversionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ConversionRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new ConversionRepository();
    }

    public function testFindTopReturnsHighestCountFirst(): void
    {
        // Three rows with different counts
        ConversionStat::factory()->create(['integer_value' => 1, 'roman' => 'I', 'conversions_count' => 5]);
        ConversionStat::factory()->create(['integer_value' => 2, 'roman' => 'II', 'conversions_count' => 10]); // top
        ConversionStat::factory()->create(['integer_value' => 3, 'roman' => 'III', 'conversions_count' => 7]);

        $results = $this->repo->findTop(2);

        // Highest counts first, only 2 records
        $this->assertCount(2, $results);
        $this->assertEquals(2, $results->first()->integer_value);
        $this->assertEquals(3, $results[1]->integer_value);
    }

    public function testFindRecentReturnsLatestFirst(): void
    {
        $now = Carbon::now();
        ConversionStat::factory()->create(['integer_value' => 10, 'roman' => 'X', 'last_converted_at' => $now->copy()->subDays(3)]);
        ConversionStat::factory()->create(['integer_value' => 20, 'roman' => 'XX', 'last_converted_at' => $now->copy()->subDay()]);
        ConversionStat::factory()->create(['integer_value' => 30, 'roman' => 'XXX', 'last_converted_at' => $now]);

        $results = $this->repo->findRecent(2);

        $this->assertCount(2, $results);
        $this->assertEquals(30, $results->first()->integer_value); // newest first
        $this->assertEquals(20, $results[1]->integer_value);
    }

    public function testFindRecentRespectsLimit(): void {
        ConversionStat::factory()->count(15)->create(); //purposely create more records than limit

        $results = $this->repo->findRecent(5);

        $this->assertCount(5, $results);
    }

    public function testFindTopRespectsLimit(): void {
        ConversionStat::factory()->count(20)->create();

        $results = $this->repo->findTop(3);

        $this->assertCount(3, $results);
    }
}

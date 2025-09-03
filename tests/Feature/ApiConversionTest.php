<?php

namespace Tests\Feature;

use App\Models\ConversionStat;
use App\Models\User;
use Tests\TestCase;

class ApiConversionTest extends TestCase
{
    public function testFindTopRejectsOversizedLimit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/top?limit=10000');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['limit']);
    }


    public function testFindTopRespectsValidLimit(): void {
        ConversionStat::factory()->count(15)->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/top?limit=5');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function testFindRecentRejecetsOversizedLimit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/recent?limit=10000');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['limit']);
    }

    public function testFindRecentRespectsValidLimit(): void
    {
        ConversionStat::factory()->count(15)->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/recent?limit=5');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }
}

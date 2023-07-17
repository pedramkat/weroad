<?php

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelsListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests  API/V1/Travels index method which should returns a paginated list of travels.
     */
    public function test_travels_list_returns_paginated_data_correctly(): void
    {
        Travel::factory(11)->create(['isPublic' => true]);

        $response = $this->get('/api/v1/travels');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonPath('meta.last_page', 3);
    }

    /**
     * Tests  API/V1/Travels index method which should returns a paginated list of travels.
     */
    public function test_travels_list_shows_only_isPublic_true(): void
    {
        $travel = Travel::factory()->create(['isPublic' => true]);
        Travel::factory()->create(['isPublic' => false]);

        $response = $this->get('/api/v1/travels');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.name', $travel->name);
    }
}

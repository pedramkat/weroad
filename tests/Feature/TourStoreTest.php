<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Carbon\Factory;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TourStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_tour_store_api_is_not_accessed_by_public_user
     */
    public function test_tour_store_api_is_not_accessed_by_public_user(): void
    {
        $travel = Travel::factory()->create();
        // public user
        $response = $this->postJson('/api/v1/travels/'.$travel->slug.'/tour');
        $response->assertStatus(401);        
    }

    /**
     * test_tour_store_api_is_not_accessed_by_editor_user
     */
    public function test_tour_store_api_is_not_accessed_by_editor_user(): void
    {        
        $travel = Travel::factory()->create();
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));
        $response = $this->actingAs($user)->postJson('/api/v1/travels/'.$travel->slug.'/tour');
        $response->assertStatus(403);
    }
    
    /**
     * test_tour_store_api_is_accessed_by_admin_user
     */
    public function test_tour_store_api_is_accessed_by_admin_user(): void
    {        
        $travel = Travel::factory()->create();
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));
        $response = $this->actingAs($user)->postJson('/api/v1/travels/'.$travel->slug.'/tour',[
            'name' => 'new tour',
            'startingDate' => now()->addDays(10),
            'endingDate' => now()->addDays(20),
            'price' => '2345'
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('data.name','new tour');
    }
}

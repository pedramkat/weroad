<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_travel_store_api_is_not_accessed_by_public_user
     */
    public function test_travel_store_api_is_not_accessed_by_public_user(): void
    {
        // public user
        $response = $this->postJson('/api/v1/travel');
        $response->assertStatus(401);
    }

    /**
     * test_travel_store_api_is_not_accessed_by_editor_user
     */
    public function test_travel_store_api_is_not_accessed_by_editor_user(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));
        $response = $this->actingAs($user)->postJson('/api/v1/travel');
        $response->assertStatus(403);
    }

    /**
     * test_travel_store_api_is_accessed_by_admin_user
     */
    public function test_travel_store_api_is_accessed_by_admin_user(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));
        $response = $this->actingAs($user)->postJson('/api/v1/travel', [
            'isPublic' => '1',
            'name' => 'test travel',
            'slug' => 'test-travel',
            'description' => 'content of the first travel',
            'numberOfDays' => '10',
            'nature' => '20',
            'relax' => '30',
            'history' => '40',
            'culture' => '50',
            'party' => '60',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('data.name', 'test travel');
    }
}

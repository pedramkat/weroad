<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToursListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_tours_list_by_travel_slug_returns_correct_tours
     */
    public function test_tours_list_by_travel_slug_returns_correct_tours(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travelId' => $travel->id]);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(1,'data');
        $response->assertJsonFragment(['id' => $tour->id]);
    }

    /**
     * test_tours_price_is_shown_correctly
     */
    public function test_tours_price_is_shown_correctly(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create([
            'travelId' => $travel->id,
            'price' => 888.45,
        ]);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(1,'data');
        $response->assertJsonFragment(['price' => '888.45']);
    }
   
    /**
     * test_tours_list_returns_pagination
     */
    public function test_tours_list_returns_pagination(): void
    {
        $toursPerPage = config('weroad.perPage');

        $travel = Travel::factory()->create();
        $tour = Tour::factory($toursPerPage + 1 )->create(['travelId' => $travel->id]);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount($toursPerPage,'data');
        $response->assertJsonPath('meta.last_page',2);
    }

    /**
     * test_tours_list_sorts_by_starting_date_correctly
     */
    public function test_tours_list_sorts_by_starting_date_correctly(): void
    {
        $travel = Travel::factory()->create();
        $firstTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'startingDate' => now()->addDays(1),
            'endingDate' => now()->addDays(4),
        ]);
        $secondTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'startingDate' => now()->addDays(5),
            'endingDate' => now()->addDays(10),
        ]);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id',$firstTour->id);
        $response->assertJsonPath('data.1.id',$secondTour->id);
    }
    
    /**
     * test_tours_list_sorts_by_price_correctly
     */
    public function test_tours_list_sorts_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $cheapFirstTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'price' => 1000,
            'startingDate' => now()->addDays(1),
            'endingDate' => now()->addDays(2),
        ]);
        $cheapSecondTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'price' => 1000,
            'startingDate' => now()->addDays(3),
            'endingDate' => now()->addDays(4),
        ]);
        $ExpensiveTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'price' => 1899,
        ]);
 
        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours?sortBy=price&sortOrder=asc');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id',$cheapFirstTour->id);
        $response->assertJsonPath('data.1.id',$cheapSecondTour->id);
        $response->assertJsonPath('data.2.id',$ExpensiveTour->id);
    }

    /**
     * test_tours_list_returns_pagination
     */
    public function test_tours_list_filter_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $cheapTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'price' => 1000,
        ]);
        $ExpensiveTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'price' => 1899,
        ]);
 
        $endpoint = '/api/v1/travels/'.$travel->slug.'/tours';
        
        $response = $this->get($endpoint.'?priceFrom=900');
        $response->assertJsonCount(2,'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id'=> $ExpensiveTour->id]);
        
        $response = $this->get($endpoint.'?priceFrom=1200');
        $response->assertJsonCount(1,'data');
        $response->assertJsonFragment(['id' => $ExpensiveTour->id]);
        
        $response = $this->get($endpoint.'?priceFrom=1900');
        $response->assertJsonCount(0,'data');

        $response = $this->get($endpoint.'?priceTo=1900');
        $response->assertJsonCount(2,'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $ExpensiveTour->id]);
        
        $response = $this->get($endpoint.'?priceTo=1200');
        $response->assertJsonCount(1,'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        
        $response = $this->get($endpoint.'?priceTo=900');
        $response->assertJsonCount(0,'data');

        $response = $this->get($endpoint.'?priceFrom=900&priceTo=1900');
        $response->assertJsonCount(2,'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $ExpensiveTour->id]);
    }

    /**
     * test_tours_list_filter_by_startingDate_correctly
     */
    public function test_tours_list_filter_by_startingDate_correctly(): void
    {
        $travel = Travel::factory()->create();
        $firstTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'startingDate' => now()->addDays(1),
            'endingDate' => now()->addDays(2),
        ]);
        $secondTour = Tour::factory()->create([
            'travelId' => $travel->id,
            'startingDate' => now()->addDays(3),
            'endingDate' => now()->addDays(4),
        ]);
 
        $endpoint = '/api/v1/travels/'.$travel->slug.'/tours';
        
        $response = $this->get($endpoint.'?dateFrom='.now());
        $response->assertJsonCount(2,'data');
        $response->assertJsonFragment(['id' => $firstTour->id]);
        $response->assertJsonFragment(['id'=> $secondTour->id]);
        
        $response = $this->get($endpoint.'?dateFrom='.now()->addDays(2));
        $response->assertJsonCount(1,'data');
        $response->assertJsonMissing(['id' => $firstTour->id]);
        $response->assertJsonFragment(['id'=> $secondTour->id]);

        $response = $this->get($endpoint.'?dateFrom='.now()->addDays(4));
        $response->assertJsonCount(0,'data');
        
        $response = $this->get($endpoint.'?dateTo='.now()->addDays(2));
        $response->assertJsonCount(1,'data');
        $response->assertJsonFragment(['id' => $firstTour->id]);
        $response->assertJsonMissing(['id'=> $secondTour->id]);
        
        $response = $this->get($endpoint.'?dateTo='.now());
        $response->assertJsonCount(0,'data');

        $response = $this->get($endpoint.'?dateFrom='.now().'&dateTo='.now()->addDays(2));
        $response->assertJsonCount(1,'data');
        $response->assertJsonFragment(['id' => $firstTour->id]);
        $response->assertJsonMissing(['id'=> $secondTour->id]);
    }

        /**
     * test_tours_list_returns_pagination
     */
    public function test_tours_list_returns_validation_errors(): void
    {
        $travel = Travel::factory()->create();
 
        $endpoint = '/api/v1/travels/'.$travel->slug.'/tours';
        
        $response = $this->getJson($endpoint.'?dateFrom=asd');
        $response->assertStatus(422);
        
        $response = $this->getJson($endpoint.'?priceFrom=asd');
        $response->assertStatus(422);
        
    }
}

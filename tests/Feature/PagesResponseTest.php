<?php

use App\Models\Story;

use function Pest\Laravel\get;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    // Apply migrations before each test
    $this->artisan('migrate');
});

// it('gives back successful response for home page', function() {
//     get(route('welcome'))->assertOK();    
// });

it('gives back successful response for stories page', function() {

    // Test the database (RefreshDatabase)


    $story1 = Story::factory()->create();    
    $story2 = Story::factory()->create();    

    get(route('stories.index'))
        ->assertOK()
        ->assertSeeText('Stories')
        ->assertSee($story1->title)
        ->assertSee($story1->subtitle)
        ->assertSee($story2->title)
        ->assertSee($story2->subtitle);  
});


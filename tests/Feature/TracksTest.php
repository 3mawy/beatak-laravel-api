<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TracksTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_tracks()
    {
        $response = $this->get('/api/tracks');
+
        $response->assertStatus(200);
    }
    public function test_get_artist_tracks()
    {
        $response = $this->get('/api/artist/{artistId}/tracks');

        $response->assertStatus(200);
    }
}

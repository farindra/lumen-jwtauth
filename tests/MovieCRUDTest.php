<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Testing\DatabaseMigrations;

class MovieCRUDTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void {

        parent::setUp();

        Artisan::call('migrate:fresh',['--seed' => true]);


    }

    /**
     * show all movie
     *
     * @return void
     */
    public function testShowAll()
    {
        
        $this->get( route('v1.movie.all') );

        $this->response->assertJson(['success' => true]);
    }

    /**
     * show movie by id
     *
     * @return void
     */
    public function testGetMovieById()
    {
        $movie = Movie::first();

        $this->get( route('v1.movie.show', ['id' => $movie->id ] ) );

        $this->response->assertJson([
            'success' => 'Movie Found'
        ])->assertStatus(200);

    }

    /**
     * show movie by id
     *
     * @return void
     */
    public function testAddViewedWithoutAuthShouldFailed()
    {
        $movie = Movie::first();
        
        $this->put( route('v1.movie.viewed', ['id' => $movie->id ] ) );

        $this->response->assertJson([
            'error' => 'Unauthorized'
        ])->assertStatus(401);

    }
}

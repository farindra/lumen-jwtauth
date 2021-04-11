<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Testing\DatabaseMigrations;

class MovieCRUDTest extends TestCase
{
    use DatabaseMigrations;

    public $token;

    public function setUp(): void {

        parent::setUp();

        Artisan::call('migrate:fresh',['--seed' => true]);

    }

    /**
     * show all movie
     *
     * @return void
     */
    public function test_show_all()
    {
        $this->get( route('v1.movie.all', ['page' => 1, 'per_page' => 15]) );

        $this->response->assertJson(['success' => true]);
    }

    /**
     * show movie by id
     *
     * @return void
     */
    public function test_get_movie_by_id()
    {
        $movie = Movie::first();

        $this->get( route('v1.movie.show', ['id' => $movie->id ] ) );

        $this->response->assertJson([
            'success' => 'Movie Found'
        ])->assertStatus(200);

    }

    /**
     * show movie by id without auth token
     *
     * @return void
     */
    public function test_add_viewed_without_auth_should_failed()
    {
        $movie = Movie::first();
        
        $this->put( route('v1.movie.viewed', ['id' => $movie->id ] ) );

        $this->response->assertJson([
            'error' => 'Unauthorized'
        ])->assertStatus(401);

    }
    
    /**
     * show movie by id with auth token
     *
     * @return void
     */
    public function test_add_viewed_with_auth_should_success(){

        $movie = Movie::first();
        
        $this->setToken();
        
        $this->put( route('v1.movie.viewed', ['id' => $movie->id ] ) );

        $this->response->assertJson([
            'success' => true,
        ])->assertStatus(200);

    }
    
    /**
     * create movie
     *
     * @return void
     */
    public function test_create_movie() {

        $this->setToken();

        $this->post( route('v1.movie.create'), [
            'title' => 'Test Movie',
            'description' => 'Test Movie Description',
            'genres' => json_encode(['action', 'horror']),
            'embed_url' => 'https://www.youtube.com/',
        ]);

        /* validate required */
        $this->response->assertJson([
            'success' => true,
        ])->assertStatus(200);

    }
    
    /**
     * update movie
     *
     * @return void
     */
    public function test_update_movie() {

        $movie = Movie::first();
        
        $this->setToken();

        $new_data = [
            'title' => 'Title Updated',
            'description' => 'Description Updated',
            'genres' => json_encode(['comedy']),
            'embed_url' => $movie->embed_url . '/updated',
        ];
        
        $this->patch( route('v1.movie.update', ['id' => $movie->id ]), $new_data);

        $this->response->assertJson([
            'success' => true,
        ])->assertStatus(200);

        /* validate if current movie is updated  */
        $new_movie = Movie::find($movie->id);

        $this->assertTrue(
            !array_diff($new_data, $new_movie->toArray())
        );

    }
    
    /**
     * delete movie
     *
     * @return void
     */
    public function test_delete_movie() {

        $movie = Movie::first();
        
        $this->setToken();

        $this->delete( route('v1.movie.delete' ,['id' => $movie->id ]));

        $this->response->assertJson([
            'success' => true,
        ])->assertStatus(200);

    }

    /**
     * set token for auth
     *
     * @return void
     */
    private function setToken() {

        /* valid register */
        $request = $this->post('/v1/register', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@email.com',
            'password' => 'secret',
        ]);

        /* valid login */
        $this->post('/v1/login', [
            'email' => 'john.doe@email.com',
            'password' => 'secret',
        ]);

    }
    
}

<?php

use Illuminate\Support\Facades\Config;

class EndpointTest extends TestCase
{
    /**
     * A basic test / endpoint.
     *
     * @return void
     */
    public function test_unknown_path_should_404()
    {
        $request = $this->get('/any/random/endpoint');

        $request->response->assertJson([
            'error' => true,
        ])->assertStatus(404);
    }

    public function test_get_version() {

        $this->get('/version');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );

    }

    public function test_ping_should_return_pong() {

        $request = $this->get('/v1/ping');

        $request->response->assertSee('pong')->assertStatus(200);

    }
}

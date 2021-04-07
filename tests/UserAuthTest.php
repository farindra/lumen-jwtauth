<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class UserAuthTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * user token
     */
    public $token = null;

    /**
     * test validate wrong user or password login 
     *
     * @return void
     */
    public function test_validate_wrong_user_or_password()
    {

        /* wrong user */
        $request = $this->post('/v1/login', [
            'email' => 'john.does@email.com',
            'password' => 'secret',
        ]);

        $request->response->assertJson([
            'error' => 'Please check your email or password !'
        ])->assertStatus(400);

        /* wrong password */
        $request = $this->post('/v1/login', [
            'email' => 'john.doe@email.com',
            'password' => 'secreto',
        ]);

        $request->response->assertJson([
            'error' => 'Please check your email or password !'
        ])->assertStatus(400);

    }
    
    /**
     * test validate valid login
     *
     * @return void
     */
    public function test_valid_login()
    {

        /* valid register */
        $request = $this->post('/v1/register', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@email.com',
            'password' => 'secret',
        ]);

        $request->response->assertJson([
            'success' => 'Account created successfully!'
        ])->assertStatus(200);

        /* valid login */
        $request = $this->post('/v1/login', [
            'email' => 'john.doe@email.com',
            'password' => 'secret',
        ]);

        $data = $request->response->decodeResponseJson()?? [];

        if ($data['success'] ?? false) {

            $this->token = $data['data']['token'] ?? '';
        }

        $request->response->assertJson([
            'success' => 'Login Success'
        ])->assertStatus(200);

    }

    /**
     * test unauthorized route auth middleware
     *
     * @return void
     */
    public function test_unauthorized_access_auth_middleware()
    {
        $request = $this->get('/v1/profile');

        $request->response->assertJson([
            'error' => 'Unauthorized'
        ])->assertStatus(401);
    }

    /**
     * test authorized route auth middleware
     *
     * @return void
     */
    public function test_authorized_access_auth_middleware()
    {
        $this->getToken();

        $request = $this->get('/v1/profile',[
            'Authorization' => "Bearer $this->token", 
        ]);

        $request->response->assertStatus(200);
    }
    
    /**
     * getToken
     *
     * @return void
     */
    private function getToken() {

        /* valid register */
        $request = $this->post('/v1/register', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@email.com',
            'password' => 'secret',
        ]);

        /* valid login */
        $request = $this->post('/v1/login', [
            'email' => 'john.doe@email.com',
            'password' => 'secret',
        ]);

        $data = $request->response->decodeResponseJson()?? [];

        if ($data['success'] ?? false) {

            $this->token = $data['data']['token'] ?? '';
        }

    }


}

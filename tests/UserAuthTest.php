<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

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
            'success' => 'Successfully login'
        ])->assertStatus(200);

    }
    
    /**
     * test authorized route auth middleware
     *
     * @return void
     */
    public function test_authorized_access_auth_middleware()
    {
        $this->setToken();

        $request = $this->get('/v1/profile');

        $request->response->assertStatus(200);
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

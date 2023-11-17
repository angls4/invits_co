<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $email = 'user@user.com';
    private $password = 'secret';

    protected function authenticateUser()
    {
        $mockEmail = 'user@user.com';
        $mockUser = User::where('email', $mockEmail)->first();
        $this->actingAs($mockUser);
        return $mockUser;
    }
    protected function seed_silent()
    {
        ob_start();
        $this->seed();
        ob_end_clean();
    }

    public function test_login_sanctum()
    {
        // Seed data in test db
        $this->seed_silent();
        
        // Assert before data from db
        $user =  auth('sanctum')->user();
        $this->assertNull($user);

        // Call the API
        $data = [
            'email' => $this->email,
            'password' => $this->password
        ];
        $response = $this->post('/api/login',$data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user' => ['id'],
                'token'
            ]
        ]);

        // Assert after data from db
        // sanctum
        $user =  auth('sanctum')->user();
        $this->assertEquals($user['id'],$response['data']['user']['id']);
        // token
        $token = $response['data']['token'];
        $sanctumToken = PersonalAccessToken::findToken($response['data']['token']);
        $this->assertEquals($user['id'], $sanctumToken->tokenable['id']);

        return $token;
    }
    public function test_login_sanctum_wrongEmail()
    {
        // Seed data in test db
        $this->seed_silent();

        // Assert before data from db
        $user =  auth('sanctum')->user();
        $this->assertNull($user);

        // Call the API
        $data = [
            'email' => $this->email . 'aaa',
            'password' => $this->password 
        ];
        $response = $this->post('/api/login', $data);

        // Assert response status and structure
        $response->assertStatus(401)->assertJsonStructure([
            'data' => [
                'errors' => [
                    'login'
                ]
            ]
        ]);

        // Assert after data from db
        $user =  auth('sanctum')->user();
        $this->assertNull($user);
    }
    public function test_login_sanctum_wrongPassword()
    {
        // Seed data in test db
        $this->seed_silent();

        // Assert before data from db
        $user =  auth('sanctum')->user();
        $this->assertNull($user);

        // Call the API
        $data = [
            'email' => $this->email,
            'password' => $this->password . 'a'
        ];
        $response = $this->post('/api/login', $data);

        // Assert response status and structure
        $response->assertStatus(401)->assertJsonStructure([
            'data' => [
                'errors' => [
                    'login'
                ]
            ]
        ]);

        // Assert after data from db
        $user =  auth('sanctum')->user();
        $this->assertNull($user);
    }
    public function test_logout()
    {
        $old_token = $this->test_login_sanctum();

        // Call the API
        $response = $this->post('/api/logout');

        // Assert response status and structure
        $response->assertStatus(200);

        // Assert after data from db
        // $this->assertNull(auth('sanctum')->user());
        $sanctumToken = PersonalAccessToken::findToken($old_token);
        $this->assertNull($sanctumToken);
    }
    public function test_logout_without_login()
    {
        // Call the API
        $response = $this->post('/api/logout', [], ['accept' => 'application/json']);

        // Assert response status
        $response->assertStatus(401);
    }
}

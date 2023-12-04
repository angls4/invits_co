<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function authenticateUser()
    {
        $mockEmail = 'user@user.com';
        $mockUser = User::where('email', $mockEmail)->first();
        $mockUser['role']= 'admin';
        $this->actingAs($mockUser);
        return $mockUser;
    }
    protected function seed_silent()
    {
        ob_start();
        $this->seed();
        ob_end_clean();
    }

    public function test_index()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_users = User::all();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/users');

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'users' => ['*' =>
                [
                    'id',
                    'profile' => [
                        'id',
                    ],
                ]]
            ],
        ]);
        // Assert count
        $expected_count = count($expected_users);
        $received_users = $response["data"]["users"];
        $this->assertCount($expected_count, $received_users, 'Data count not same');
        // Assert data integrity and consistency
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 17;
        $expected_users_ids = $expected_users->map(fn ($user) => $user['id'])->toArray();
        foreach ($received_users as $user) {
            if (!in_array($user['id'], $expected_users_ids)) {
                $integrityStatus = false;
            }
            if (count($user) != $expectedStructureCount) {
                $consistencyStatus = false;
            }
        }
        $this->assertTrue($integrityStatus, 'Data IDs not consistent');
        $this->assertTrue($consistencyStatus, 'Data Structures not consistent');
    }

    public function test_show()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_user = User::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/users/' . $expected_user['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'profile' => [
                        'id',
                    ],
                ],
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 17;
        $received_user = $response["data"]["user"];
        $this->assertCount($expectedStructureCount, $received_user, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_user['id'], $expected_user['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/users/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
   
    public function test_update()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_user = User::take(1)->first();
        
        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "first_name" => "John",
            "last_name" => "Doe",
            "username" => "johndoe123",
            "email" => "john.doe@example.com",
            "mobile" => "+1-555-1234",
            "gender" => "Male",
            "date_of_birth" => "1990-05-15",
            "avatar" => "path/to/avatar.jpg",
            "url_website" => "https://www.example.com",
            "url_facebook" => "https://www.facebook.com/johndoe",
            "url_twitter" => "https://twitter.com/johndoe",
            "url_instagram" => "https://www.instagram.com/johndoe",
            "url_linkedin" => "https://www.linkedin.com/in/johndoe",
            "address" => "123 Main Street, Cityville",
            "bio" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
        ];
        $response = $this->put('/api/users/' . $expected_user['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'profile' => [
                        'id',
                    ],
                ],
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $this->assertNotEquals($expected_user['updated_at'], $response['data']['user']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_update_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->put('/api/users/' . 999, []);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_update_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_user = User::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "first_name" => "",
            "last_name" => "",
            "username" => "",
            "email" => "",
            "mobile" => "",
            "gender" => "",
            "date_of_birth" => "",
            "avatar" => "",
            "url_website" => "",
            "url_facebook" => "",
            "url_twitter" => "",
            "url_instagram" => "",
            "url_linkedin" => "",
            "address" => "",
            "bio" => ""
        ];
        $response = $this->put('/api/users/' . $expected_user['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "email"
            ],
        ]);
    }
    public function test_update_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_user = User::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [];
        $response = $this->put('/api/users/' . $expected_user['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'profile' => [
                        'id',
                    ],
                ],
            ],
        ]);
        // Assert data integrity
        $expected_data = [
            "first_name" => $expected_user['first_name'],
            "last_name" => $expected_user['last_name'],
            "username" => $expected_user['username'],
            "email" =>  $expected_user['email'],
            "mobile" =>  $expected_user['mobile'],
            "gender" => $expected_user['gender'],
            "date_of_birth" =>  $expected_user['date_of_birth'],
            "avatar" =>  $expected_user['avatar'],
            "url_website" => $expected_user['url_website'],
            "url_facebook" =>  $expected_user['url_facebook'],
            "url_twitter" =>  $expected_user['url_twitter'],
            "url_instagram" =>  $expected_user['url_instagram'],
            "url_linkedin" =>  $expected_user['url_linkedin'],
            "address" =>  $expected_user['address'],
            "bio" =>  $expected_user['bio']
        ];
        $this->assertNotEquals($expected_user['updated_at'], $response['data']['user']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }

    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_user = User::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/users/' . $expected_user['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_user = User::where('id', $expected_user['id'])->first();
        $this->assertNull($received_user, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/users/' . $expected_user['id'], $data);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_destroy_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/users/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
}

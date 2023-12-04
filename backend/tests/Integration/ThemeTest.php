<?php

namespace Tests\Unit;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ThemeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function authenticateUser()
    {
        $mockEmail = 'user@user.com';
        $mockUser = User::where('email', $mockEmail)->first();
        $mockUser['role'] = 'admin';
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
        $expected_themes = Theme::all();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/themes');

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'themes' => ['*' =>
                [
                    'id',
                    'package' => [
                        'id'
                    ]
                ]]
            ],
        ]);
        // Assert count
        $expected_count = count($expected_themes);
        $received_themes = $response["data"]["themes"];
        $this->assertCount($expected_count, $received_themes, 'Data count not same');
        // Assert data integrity and consistency
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 14;
        $expected_themes_ids = $expected_themes->map(fn ($theme) => $theme['id'])->toArray();
        foreach ($received_themes as $theme) {
            if (!in_array($theme['id'], $expected_themes_ids)) {
                $integrityStatus = false;
            }
            if (count($theme) != $expectedStructureCount) {
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
        $expected_theme = Theme::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/themes/' . $expected_theme['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'theme' => [
                    'id',
                    'package' => [
                        'id'
                    ]
                ],
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 14;
        $received_theme = $response["data"]["theme"];
        $this->assertCount($expectedStructureCount, $received_theme, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_theme['id'], $expected_theme['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/themes/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
    public function test_store()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "package_id"=> 1,
            "name"=> "New Theme",
            "price"=> 500000,
            "description"=> "Desc New Theme",
            "slug"=> "new-theme",
            "img_preview"=> "string"
        ];
        $response = $this->post('/api/themes/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'theme' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $response->assertJsonFragment($expected_data);
    }
    public function test_store_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "package_id" => "",
            "name" => "",
            "price" => "",
            "description" => "",
            "slug" => "",
            "img_preview" => ""
        ];
        $response = $this->post('/api/themes/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "package_id",
                "name",
                "price",
                "description",
                "slug",
                "img_preview"
            ],
        ]);
    }
    public function test_store_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [];
        $response = $this->post('/api/themes/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "package_id",
                "name",
                "price"
            ],
        ]);
    }

    public function test_update()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_theme = Theme::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "package_id" => 1,
            "name" => "edited Theme",
            "price" => 500000,
            "description" => "Desc edited Theme",
            "slug" => "edited-theme",
            "img_preview" => "string"
        ];
        $response = $this->post('/api/themes/' . $expected_theme['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'theme' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $this->assertNotEquals($expected_theme['updated_at'], $response['data']['theme']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_update_nonExistentForeignId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_theme = Theme::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "package_id" => 100,
            "name" => "edited Theme",
            "price" => 500000,
            "description" => "Desc edited Theme",
            "slug" => "edited-theme",
            "img_preview" => "string"
        ];
        $response = $this->post('/api/themes/' . $expected_theme['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'package_id'
            ],
        ]);
    }
    public function test_update_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->post('/api/themes/' . 999, []);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_update_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_theme = Theme::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "package_id" => "",
            "name" => "",
            "price" => "",
            "description" => "",
            "slug" => "",
            "img_preview" => ""
        ];
        $response = $this->post('/api/themes/' . $expected_theme['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "package_id",
                "name",
                "price",
                "description",
                "slug",
                "img_preview"
            ],
        ]);
    }
    public function test_update_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_theme = Theme::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [];
        $response = $this->post('/api/themes/' . $expected_theme['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'theme' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = [
            "package_id" => $expected_theme['package_id'],
            "name" => $expected_theme['name'],
            "price" => $expected_theme['price'],
            "description" =>  $expected_theme['description'],
            "slug" =>  $expected_theme['slug'],
            "img_preview" =>  $expected_theme['img_preview']
        ];
        $this->assertNotEquals($expected_theme['updated_at'], $response['data']['theme']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }

    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_theme = Theme::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/themes/' . $expected_theme['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_theme = Theme::where('id', $expected_theme['id'])->first();
        $this->assertNull($received_theme, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/themes/' . $expected_theme['id'], $data);

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
        $response = $this->delete('/api/themes/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
}

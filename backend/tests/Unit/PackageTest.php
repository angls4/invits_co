<?php

namespace Tests\Unit;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PackageTest extends TestCase
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
        $expected_packages = Package::all();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/packages');

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'packages',
            ],
        ]);
        // Assert count
        $expected_count = count($expected_packages);
        $received_packages = $response["data"]["packages"];
        $this->assertCount($expected_count, $received_packages, 'Data count not same');
        // Assert data integrity and consistency
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 11;
        $expected_packages_ids = $expected_packages->map(fn ($package) => $package['id'])->toArray();
        foreach ($received_packages as $package) {
            if (!in_array($package['id'], $expected_packages_ids)) {
                $integrityStatus = false;
            }
            if (count($package) != $expectedStructureCount) {
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
        $expected_package = Package::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/packages/' . $expected_package['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'package' => ['id'],
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 11;
        $received_package = $response["data"]["package"];
        $this->assertCount($expectedStructureCount, $received_package, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_package['id'], $expected_package['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/packages/' . 999);

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
        "name" => "Package new",
        "price" => "Rp. 1.000.000",
        "description" => "A new package",
        "features" => "<li>Informasi Dasar Pernikahan</li><li>Save to Google Calendar</li>"
        ];
        $response = $this->post('/api/packages/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'package' => ['id']
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
            "name" => "",
            "price" => "",
            "description" => "",
            "features" => ""
        ];
        $response = $this->post('/api/packages/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "name",
                "price",
                "description",
                "features"
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
        $response = $this->post('/api/packages/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "name",
                "price",
                "description",
                "features"
            ],
        ]);
    }

    public function test_update()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_package = Package::take(1)->first();
        
        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "name" => "Package edited",
            "price" => "Rp. 1.000.000",
            "description" => "An edited package",
            "features" => "EDITED"
        ];
        $response = $this->put('/api/packages/' . $expected_package['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'package' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $this->assertNotEquals($expected_package['updated_at'], $response['data']['package']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_update_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->put('/api/packages/' . 999, []);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_update_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_package = Package::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "name" => "",
            "price" => "",
            "description" => "",
            "features" => ""
        ];
        $response = $this->put('/api/packages/' . $expected_package['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "name",
                "price",
                "description",
                "features"
            ],
        ]);
    }
    public function test_update_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_package = Package::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [];
        $response = $this->put('/api/packages/' . $expected_package['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "name",
                "price",
                "description",
                "features"
            ],
        ]);
    }

    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_package = Package::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/packages/' . $expected_package['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_package = Package::where('id', $expected_package['id'])->first();
        $this->assertNull($received_package, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/packages/' . $expected_package['id'], $data);

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
        $response = $this->delete('/api/packages/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
}

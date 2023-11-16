<?php

namespace Tests\Unit;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class GuestTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    protected function authenticateUser()
    {
        $mockEmail = 'user@user.com';
        $mockUser = User:: where('email', $mockEmail)->first();
        $this->actingAs($mockUser);
        return $mockUser;
    }
    protected function seed_silent()
    {
        ob_start();
        $this->seed();
        ob_end_clean();
    }

    public function test_index(){
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_guests = Guest::all();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/guests');

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'guests' => ['*' => ['id']],
            ],
        ]);
        // Assert count
        $expected_count = count($expected_guests);
        $received_guests = $response["data"]["guests"];
        $this->assertCount($expected_count, $received_guests, 'Data count not same');
        // Assert data integrity and consistency
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 14;
        $expected_guests_ids = $expected_guests->map(fn ($guest) => $guest['id'])->toArray();
        foreach ($received_guests as $guest) {
            if (!in_array($guest['id'],$expected_guests_ids)) {
                $integrityStatus = false;
            }
            if (count($guest) != $expectedStructureCount) {
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
        $expected_guest = Guest::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/guests/'.$expected_guest['id']);
        
        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'guest' => ['id'],
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 14;
        $received_guest = $response["data"]["guest"];
        $this->assertCount($expectedStructureCount,$received_guest, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_guest['id'],$expected_guest['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/guests/' . 999);

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
        $jsonData = '{
        "name": "NEW ENTRY",
        "description": "Some description",
        "address": "123 Main St",
        "is_invited": true,
        "no_whats_app": "1234567890",
        "email": "johndoe@example.com",
        "invitation_id": 1
        }';
        $data = json_decode($jsonData, true);
        $response = $this->post('/api/guests/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'guest'
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $response->assertJsonFragment($expected_data);
    }
    public function test_store_nonExistentInvitationId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{
        "name": "NEW ENTRY",
        "is_invited": true,
        "invitation_id": 999
        }';
        $data = json_decode($jsonData, true);
        $response = $this->post('/api/guests/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'invitation_id'
            ],
        ]);
    }
    public function test_store_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{
        "name": "",
        "description": "",
        "address": "",
        "is_invited": "",
        "no_whats_app": "",
        "email": "",
        "invitation_id": ""
        }';
        $data = json_decode($jsonData, true);
        $response = $this->post('/api/guests/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
                'is_invited',
                'invitation_id'
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
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->post('/api/guests/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
                'is_invited',
                'invitation_id'
            ],
        ]);
    }

    public function test_update()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_guest = Guest::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{
        "name": "Updated Name",
        "description": "Updated description",
        "address": "456 Elm St",
        "is_invited": false,
        "no_whats_app": "0987654321",
        "email": "updated@example.com",
        "invitation_id": 1
        }';
        $data = json_decode($jsonData, true);
        $response = $this->put('/api/guests/' . $expected_guest['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'guest' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $this->assertNotEquals($expected_guest['updated_at'], $response['data']['guest']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_update_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->put('/api/guests/' . 999);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_update_nonExistentInvitationId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_guest = Guest::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{
        "invitation_id": 999
        }';
        $data = json_decode($jsonData, true);
        $response = $this->put('/api/guests/' . $expected_guest['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'invitation_id'
            ],
        ]);
    }
    public function test_update_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_guest = Guest::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{
        "name": "",
        "description": "",
        "address": "",
        "is_invited": "",
        "no_whats_app": "",
        "email": "",
        "invitation_id": ""
        }';
        $data = json_decode($jsonData, true);
        $response = $this->put('/api/guests/' . $expected_guest['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
                'is_invited',
                'invitation_id'
            ],
        ]);
    }
    public function test_update_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_guest = Guest::take(1)->first();
        
        // Mock authentication
        $user = $this->authenticateUser();
        
        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->put('/api/guests/' . $expected_guest['id'], $data);
        
        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'guest' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = [
            'id' => $expected_guest['id'],
            'name' => $expected_guest['name'],
            'description' => $expected_guest['description'],
            'address' => $expected_guest['address'],
            'no_whats_app' => $expected_guest['no_whats_app'],
            'email' => $expected_guest['email'],
            'invitation_id' => $expected_guest['invitation_id'],
        ];
        $this->assertNotEquals($expected_guest['updated_at'], $response['data']['guest']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_guest = Guest::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/guests/' . $expected_guest['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_guest = Guest::where('id',$expected_guest['id'])->first();
        $this->assertNull($received_guest, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/guests/' . $expected_guest['id'], $data);

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
        $response = $this->delete('/api/guests/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_getByInvitationId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitation = Invitation::where('id', Guest::take(1)->first()['invitation_id'])->take(1)->first();
        $invitation_id = $expected_invitation['id'];
        $expected_guests = Guest::where('invitation_id', $invitation_id)->get();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/guests-invitation/' . $invitation_id);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'invitation' => ['id'],
                'guests' => ['*' => ['id']],
            ],
        ]);
        // Assert count
        $expected_count = count($expected_guests);
        $received_guests = $response["data"]["guests"];
        $this->assertCount($expected_count, $received_guests, 'Data count not same');
        // Assert data integrity and consistency
        // for invitation
        $this->assertEquals($response['data']['invitation']['id'],$invitation_id, 'Invitation ID not consistent');
        // for guest
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 14;
        $expected_guests_ids = $expected_guests->map(fn ($guest) => $guest['id'])->toArray();
        foreach ($received_guests as $guest) {
            if (!in_array($guest['id'], $expected_guests_ids)) {
                $integrityStatus = false;
            }
            if (count($guest) != $expectedStructureCount) {
                $consistencyStatus = false;
            }
        }
        $this->assertTrue($integrityStatus, 'Guests IDs not consistent');
        $this->assertTrue($consistencyStatus, 'Guests Structures not consistent');
    }
    public function test_getByInvitationId_nonExistentInvitationId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/guests-invitation/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
}

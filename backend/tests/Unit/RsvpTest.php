<?php

namespace Tests\Unit;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Rsvp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class RsvpTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

    // public function test_index()
    // {
    //     // Seed data in test db
    //     $this->seed_silent();

    //     // Get expected data from db
    //     $expected_rsvps = Rsvp::all();

    //     // Mock authentication
    //     $user = $this->authenticateUser();

    //     // Call the API
    //     $response = $this->get('/api/rsvps');

    //     // Assert response status and structure
    //     $response->assertStatus(200)->assertJsonStructure([
    //         'data' => [
    //             'rsvps',
    //         ],
    //     ]);
    //     // Assert count
    //     $expected_count = count($expected_rsvps);
    //     $received_rsvps = $response["data"]["rsvps"];
    //     $this->assertCount($expected_count, $received_rsvps, 'Data count not same');
    //     // Assert data integrity and consistency
    //     $integrityStatus = true;
    //     $consistencyStatus = true;
    //     $expectedStructureCount = 9;
    //     $expected_rsvps_ids = $expected_rsvps->map(fn ($rsvp) => $rsvp['id'])->toArray();
    //     foreach ($received_rsvps as $rsvp) {
    //         if (!in_array($rsvp['id'], $expected_rsvps_ids)) {
    //             $integrityStatus = false;
    //         }
    //         if (count($rsvp) != $expectedStructureCount) {
    //             $consistencyStatus = false;
    //         }
    //     }
    //     $this->assertTrue($integrityStatus, 'Data IDs not consistent');
    //     $this->assertTrue($consistencyStatus, 'Data Structures not consistent');
    // }

    public function test_show()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_rsvp = Rsvp::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/rsvps/' . $expected_rsvp['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'rsvp' => ['id'],
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 9;
        $received_rsvp = $response["data"]["rsvp"];
        $this->assertCount($expectedStructureCount, $received_rsvp, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_rsvp['id'], $expected_rsvp['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/rsvps/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
    public function test_store()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $invitation_id = Invitation::take(1)->first()['id'];
        $guest_id = Guest::take(1)->first()['id'];

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "name" => "new-entry",
            "amount_guest" => 2,
            "is_attend" => true,
            "invitation_id" => $invitation_id,
            "guest_id" => $guest_id
        ];
        $response = $this->post('/api/rsvps/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'rsvp' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $response->assertJsonFragment($expected_data);
    }
    public function test_store_nonExistentForeignId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
                "name" => "new-entry",
                "amount_guest" => 2,
                "is_attend" => true,
                "invitation_id" => 999,
                "guest_id" => 999
            ];
        $response = $this->post('/api/rsvps/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'invitation_id',
                'guest_id'
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
        $data = [
                "name" => "",
                "amount_guest" => "",
                "is_attend" => "",
                "invitation_id" => "",
                "guest_id" => ""
            ];
        $response = $this->post('/api/rsvps/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
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
        $data = [
        ];
        $response = $this->post('/api/rsvps/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
                'invitation_id'
            ],
        ]);
    }
/*
    public function test_update()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_rsvp = Rsvp::take(1)->first();
        $invitation_id = Invitation::take(1)->first()['id'];
        $guest_id = Guest::take(1)->first()['id'];
        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "name" => "new-entry",
            "amount_guest" => 2,
            "is_attend" => true,
            "invitation_id" => $invitation_id,
            "guest_id" => $guest_id
        ];
        $response = $this->put('/api/rsvps/'.$expected_rsvp['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'rsvp' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $this->assertNotEquals($expected_rsvp['updated_at'], $response['data']['invi$expected_rsvp']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_update_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->put('/api/rsvps/' . 999, []);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_update_nonExistentForeignId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_rsvp = Rsvp::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
                "name" => "new-entry",
                "amount_guest" => 2,
                "is_attend" => true,
                "invitation_id" => 999,
                "guest_id" => 999
            ];
        $response = $this->put('/api/rsvps/'.$expected_rsvp['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'invitation_id',
                'guest_id'
            ],
        ]);
    }
    public function test_update_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_rsvp = Rsvp::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
                "name" => "",
                "amount_guest" => "",
                "is_attend" => "",
                "invitation_id" => "",
                "guest_id" => ""
            ];
        $response = $this->put('/api/rsvps/'.$expected_rsvp['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
                'amount_guest',
                'is_attend',
                'invitation_id',
            ],
        ]);
    }
    public function test_update_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_rsvp = Rsvp::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [];
        $response = $this->put('/api/rsvps/' . $expected_rsvp['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'rsvp' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = [
            "id" => $expected_rsvp['id'],
            "name" => $expected_rsvp['name'],
            "amount_guest" => $expected_rsvp['amount_guest'],
            "is_attend" =>  $expected_rsvp['is_attend'],
            "invitation_id" =>  $expected_rsvp['invitation_id'],
            "guest_id" =>  $expected_rsvp['guest_id'],
        ];
        $this->assertNotEquals($expected_rsvp['updated_at'], $response['data']['rsvp']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
*/
    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_rsvp = Rsvp::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/rsvps/' . $expected_rsvp['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_rsvp = Rsvp::where('id', $expected_rsvp['id'])->first();
        $this->assertNull($received_rsvp, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/rsvps/' . $expected_rsvp['id'], $data);

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
        $response = $this->delete('/api/rsvps/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_getByInvitationId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitation = Invitation::where('id', Rsvp::take(1)->first()['invitation_id'])->take(1)->first();
        $invitation_id = $expected_invitation['id'];
        $expected_rsvps = Rsvp::where('invitation_id', $invitation_id)->get();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/rsvps-invitation/' . $invitation_id);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'invitation' => ['id'],
                'rsvps' => ['*' => ['id']],
            ],
        ]);
        // Assert count
        $expected_count = count($expected_rsvps);
        $received_rsvps = $response["data"]["rsvps"];
        $this->assertCount($expected_count, $received_rsvps, 'Data count not same');
        // Assert data integrity and consistency
        // for invitation
        $this->assertEquals($response['data']['invitation']['id'], $invitation_id, 'Invitation ID not consistent');
        // for rsvp
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 9;
        $expected_rsvps_ids = $expected_rsvps->map(fn ($rsvp) => $rsvp['id'])->toArray();
        foreach ($received_rsvps as $rsvp) {
            if (!in_array($rsvp['id'], $expected_rsvps_ids)) {
                $integrityStatus = false;
            }
            if (count($rsvp) != $expectedStructureCount) {
                $consistencyStatus = false;
            }
        }
        $this->assertTrue($integrityStatus, 'Rsvps IDs not consistent');
        $this->assertTrue($consistencyStatus, 'Rsvps Structures not consistent');
    }
    public function test_getByInvitationId_nonExistentInvitationId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/rsvps-invitation/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }

}

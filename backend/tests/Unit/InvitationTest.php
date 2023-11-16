<?php

namespace Tests\Unit;

use App\Models\Invitation;
use App\Models\InvitationType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class InvitationTest extends TestCase
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

    public function test_index()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitations = Invitation::all();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/invitations');

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'invitations',
            ],
        ]);
        // Assert count
        $expected_count = count($expected_invitations);
        $received_invitations = $response["data"]["invitations"];
        $this->assertCount($expected_count, $received_invitations, 'Data count not same');
        // Assert data integrity and consistency
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 11;
        $expected_invitations_ids = $expected_invitations->map(fn ($invitation) => $invitation['id'])->toArray();
        foreach ($received_invitations as $invitation) {
            if (!in_array($invitation['id'], $expected_invitations_ids)) {
                $integrityStatus = false;
            }
            if (count($invitation) != $expectedStructureCount) {
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
        $expected_invitation = Invitation::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/invitations/' . $expected_invitation['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'invitation' => [
                    'id',
                    'type' => 'id',
                    'wedding' => [
                        'id',
                        'groom' => 'id',
                        'bride' => 'id',
                        'wish' => 'id',
                        'gift' => 'id',
                        'event' => 'id',
                        'love_story' => 'id',
                        'gallery' => 'id'
                    ],
                ],
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 13;
        $received_invitation = $response["data"]["invitation"];
        $this->assertCount($expectedStructureCount, $received_invitation, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_invitation['id'], $expected_invitation['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/invitations/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
    public function test_store_twice()
    {
        // Seed data in test db
        $this->seed_silent();
        
        // Mock authentication
        $user = $this->authenticateUser();
        
        // Get expected data from db
        $user_id = User::take(1)->first()['id'];
        $order_id = Order::take(1)->first()['id'];
        $invitation_type_id = InvitationType::take(1)->first()['id'];


        // Call the API
        $data = [
            "status" => "ACTIVE",
            "slug" => "new-entry",
            "is_custom_domain" => true,
            "custom_domain" => "custom-domain-new",
            "user_id" => $user_id,
            "order_id" => $order_id,
            "invitation_type_id" => $invitation_type_id
        ];
        $response = $this->post('/api/invitations/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'invitation' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $response->assertJsonFragment($expected_data);

        // SECOND TIME

        // Call the API
        $data = [
            "status" => "ACTIVE",
            "slug" => "new-entry",
            "is_custom_domain" => true,
            "custom_domain" => "custom-domain-new",
            "user_id" => $user_id,
            "order_id" => $order_id,
            "invitation_type_id" => $invitation_type_id
        ];
        $response = $this->post('/api/invitations/', $data);

        // Assert response status and structure
        $response->assertStatus(441)->assertJsonStructure([
            'errors' => [
                'slug'
            ],
        ]);
    }
    public function test_store_nonExistentForeignId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "status" => "ACTIVE",
            "slug" => "new-entry",
            "is_custom_domain" => true,
            "custom_domain" => "custom-domain-new",
            "user_id" => 999,
            "order_id" => 999,
            "invitation_type_id" => 999
        ];
        $response = $this->post('/api/invitations/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'user_id',
                'order_id',
                'invitation_type_id'
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
            "status" => "",
            "slug" => "",
            "is_custom_domain" => "",
            "custom_domain" => "",
            "user_id" => "",
            "order_id" => "",
            "invitation_type_id" => ""
        ];
        $response = $this->post('/api/invitations/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'status',
                'is_custom_domain',
                'user_id',
                'order_id',
                'invitation_type_id'
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
        $response = $this->post('/api/invitations/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'status',
                'is_custom_domain',
                'user_id',
                'order_id',
                'invitation_type_id'
            ],
        ]);
    }

    public function test_update()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitation = Invitation::take(1)->first();
        $user_id = User::take(1)->first()['id'];
        $order_id = Order::take(1)->first()['id'];
        $invitation_type_id = InvitationType::take(1)->first()['id'];

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "status" => "ACTIVE",
            "slug" => "updated-entry",
            "is_custom_domain" => true,
            "custom_domain" => "custom-domain-updated",
            "user_id" => $user_id,
            "order_id" => $order_id,
            "invitation_type_id" => $invitation_type_id
        ];
        $response = $this->put('/api/invitations/' . $expected_invitation['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'invitation' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $this->assertNotEquals($expected_invitation['updated_at'], $response['data']['invitation']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_update_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->put('/api/invitations/' . 999, []);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_update_nonExistentForeignId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitation = Invitation::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "status" => "ACTIVE",
            "slug" => "updated-entry",
            "is_custom_domain" => true,
            "custom_domain" => "custom-domain-updated",
            "user_id" => 999,
            "order_id" => 999,
            "invitation_type_id" => 999
        ];
        $response = $this->put('/api/invitations/' . $expected_invitation['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'user_id',
                'order_id',
                'invitation_type_id'
            ],
        ]);
    }
    public function test_update_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitation = Invitation::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "status" => "",
            "slug" => "",
            "is_custom_domain" => "",
            "custom_domain" => "",
            "user_id" => "",
            "order_id" => "",
            "invitation_type_id" => ""
        ];
        $response = $this->put('/api/invitations/' . $expected_invitation['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'status',
                'is_custom_domain',
                'user_id',
                'order_id',
                'invitation_type_id'
            ],
        ]);
    }
    public function test_update_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitation = Invitation::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [];
        $response = $this->put('/api/invitations/' . $expected_invitation['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'invitation' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = [
            "id" => $expected_invitation['id'],
            "status" => $expected_invitation['status'],
            "slug" =>  $expected_invitation['slug'],
            "is_custom_domain" =>  $expected_invitation['is_custom_domain'],
            "custom_domain" =>  $expected_invitation['custom_domain'],
            "user_id" =>  $expected_invitation['user_id'],
            "order_id" =>  $expected_invitation['order_id'],
            "invitation_type_id" =>  $expected_invitation['invitation_type_id'],
        ];
        $this->assertNotEquals($expected_invitation['updated_at'], $response['data']['invitation']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_invitation = Invitation::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/invitations/' . $expected_invitation['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_invitation = Invitation::where('id', $expected_invitation['id'])->first();
        $this->assertNull($received_invitation, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/invitations/' . $expected_invitation['id'], $data);

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
        $response = $this->delete('/api/invitations/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
}

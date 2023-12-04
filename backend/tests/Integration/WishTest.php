<?php

namespace Tests\Unit;

use App\Models\Wish;
use App\Models\User;
use App\Models\Wedding;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class WishTest extends TestCase
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

    public function test_show()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_wish = Wish::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/wishes/' . $expected_wish['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'wish' => ['id'],
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 8;
        $received_wish = $response["data"]["wish"];
        $this->assertCount($expectedStructureCount, $received_wish, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_wish['id'], $expected_wish['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/wishes/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
    public function test_store()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $wedding_id = Wedding::take(1)->first()['id'];

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "name" => "new-entry",
            "from" => "new-sender",
            "wish" => "Best wishes for a happy marriage!",
            "wedding_id" => $wedding_id
        ];
        $response = $this->post('/api/wishes/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'wish' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $response->assertJsonFragment($expected_data);
    }
    public function test_store_anonymous()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $wedding_id = Wedding::take(1)->first()['id'];

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "wish" => "Best wishes for a happy marriage!",
            "anonymous" => true,
            "wedding_id" => $wedding_id
        ];
        $response = $this->post('/api/wishes/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'wish' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $data['name'] = 'Anonim';
        $data['from'] = null;
        unset($expected_data['anonymous']);
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
            "from" => "new-sender",
            "wish" => "Best wishes for a happy marriage!",
            "wedding_id" => 999
        ];
        $response = $this->post('/api/wishes/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'wedding_id',
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
            "from" => "",
            "wish" => "",
            "wedding_id" => ""
        ];
        $response = $this->post('/api/wishes/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
                'from',
                'wish',
                'wedding_id'
            ],
        ]);
    }
    public function test_store_anonymous_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "name" => "",
            "from" => "",
            "wish" => "",
            "anonymous" => true,
            "wedding_id" => ""
        ];
        $response = $this->post('/api/wishes/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'wish',
                'wedding_id'
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
        $response = $this->post('/api/wishes/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'wish',
                'wedding_id'
            ],
        ]);
    }
    public function test_store_anonymous_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "anonymous" => true
        ];
        $response = $this->post('/api/wishes/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'wish',
                'wedding_id'
            ],
        ]);
    }

    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_wish = Wish::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/wishes/' . $expected_wish['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_wish = Wish::where('id', $expected_wish['id'])->first();
        $this->assertNull($received_wish, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/wishes/' . $expected_wish['id'], $data);

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
        $response = $this->delete('/api/wishes/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_getByWeddingId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_wedding = Wedding::where('id', Wish::take(1)->first()['wedding_id'])->take(1)->first();
        $wedding_id = $expected_wedding['id'];
        $expected_wishes = Wish::where('wedding_id', $wedding_id)->get();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/wishes-wedding/' . $wedding_id);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                // 'wedding' => ['id'],
                'wishes' => ['*' => ['id']],
            ],
        ]);
        // Assert count
        $expected_count = count($expected_wishes);
        $received_wishes = $response["data"]["wishes"];
        $this->assertCount($expected_count, $received_wishes, 'Data count not same');
        // Assert data integrity and consistency
        // for wedding
        // $this->assertEquals($response['data']['wedding']['id'], $wedding_id, 'Wedding ID not consistent');
        // for wish
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 8;
        $expected_wishes_ids = $expected_wishes->map(fn ($wish) => $wish['id'])->toArray();
        foreach ($received_wishes as $wish) {
            if (!in_array($wish['id'], $expected_wishes_ids)) {
                $integrityStatus = false;
            }
            if (count($wish) != $expectedStructureCount) {
                $consistencyStatus = false;
            }
        }
        $this->assertTrue($integrityStatus, 'Wishs IDs not consistent');
        $this->assertTrue($consistencyStatus, 'Wishs Structures not consistent');
    }
    public function test_getByWeddingId_nonExistentWeddingId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/wishes-wedding/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
}

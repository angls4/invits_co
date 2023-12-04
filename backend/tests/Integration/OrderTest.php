<?php

namespace Tests\Unit;


use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class OrderTest extends TestCase
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
        $expected_orders = Order::all();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/orders');

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'orders' => ['*' => [
                    'id',
                    'invitation' => 'id',
                    'theme' => 'id'
                ],
            ]],
        ]);
        // Assert count
        $expected_count = count($expected_orders);
        $received_orders = $response["data"]["orders"];
        $this->assertCount($expected_count, $received_orders, 'Data count not same');
        // Assert data integrity and consistency
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 13;
        $expected_orders_ids = $expected_orders->map(fn ($order) => $order['id'])->toArray();
        foreach ($received_orders as $order) {
            if (!in_array($order['id'], $expected_orders_ids)) {
                $integrityStatus = false;
            }
            if (count($order) != $expectedStructureCount) {
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
        $expected_order = Order::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/orders/' . $expected_order['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'order' => 
                    [
                        'id',
                        'invitation' => 'id',
                        'user' => 'id',
                        'package' => 'id',
                        'payment' => 'id',
                        'theme' => 'id'
                    ],
                
            ],
        ]);
        // Assert data consistency
        $expectedStructureCount = 16;
        $received_order = $response["data"]["order"];
        $this->assertCount($expectedStructureCount, $received_order, 'Data Structures not consistent');
        // Assert data integrity
        $this->assertEquals($received_order['id'], $expected_order['id'], 'Data IDs not consistent');
    }
    public function test_show_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/orders/' . 999);

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
            "user_id" => $user['id'],
            "theme_id" => 1,
        ];
        $response = $this->post('/api/orders/', $data);

        // Assert response status and structure
        $response->assertStatus(201)->assertJsonStructure([
            'data' => [
                'theme' => [
                    'id'
                ],
                'payment_midtrans'
            ],
        ]);
        // Assert data integrity
        $this->assertStringContainsString('test-dummy-snap-token',$response['data']['payment_midtrans']);
        return $response['data']['payment_midtrans'];
    }
    public function test_store_nonExistentForeignKeys()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "user_id" => 999,
            "theme_id" => 999
        ];
        $response = $this->post('/api/orders/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "user_id",
                "theme_id"
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
            "user_id" => "",
            "theme_id" => ""
        ];
        $response = $this->post('/api/orders/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "user_id",
                "theme_id"
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
        $response = $this->post('/api/orders/', $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "user_id",
                "theme_id"
            ],
        ]);
    }
/*
    public function test_update()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_order = Order::take(1)->first();
        $expected_package = Package::take(1)->first();
        $expected_theme = Theme::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            'status' => 'PAID',
            'user_id' => $user['id'],
            'package_id' => $expected_package['id'],
            'theme_id' => $expected_theme['id'],
        ];
        $response = $this->put('/api/orders/' . $expected_order['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'order' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = $data;
        $this->assertNotEquals($expected_order['updated_at'], $response['data']['order']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
    public function test_update_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->put('/api/orders/' . 999, []);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_update_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_order = Order::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [
            "status" => "",
            "user_id" => "",
            "package_id" => "",
            "theme_id" => ""
        ];
        $response = $this->put('/api/orders/' . $expected_order['id'], $data);

        // Assert response status and structure
        $response->assertStatus(422)->assertJsonStructure([
            'errors' => [
                "status",
                "user_id",
                "package_id",
                "theme_id"
            ],
        ]);
    }
    public function test_update_emptyData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_order = Order::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $data = [];
        $response = $this->put('/api/orders/' . $expected_order['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'order' => ['id']
            ],
        ]);
        // Assert data integrity
        $expected_data = [
            "id" => $expected_order['id'],
            "status" => $expected_order['status'],
            "user_id" => $expected_order['user_id'],
            "package_id" =>  $expected_order['package_id'],
            "theme_id" =>  $expected_order['theme_id'],
        ];
        $this->assertNotEquals($expected_order['updated_at'], $response['data']['order']['updated_at'], 'updated_at not updated');
        $response->assertJsonFragment($expected_data);
    }
*/
    public function test_destroy_twice()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_order = Order::take(1)->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/orders/' . $expected_order['id'], $data);

        // Assert response status
        $response->assertStatus(200);
        // Assert data integrity
        $received_order = Order::where('id', $expected_order['id'])->first();
        $this->assertNull($received_order, 'not destroyed');

        // SECOND TIME

        // Call the API
        $jsonData = '{}';
        $data = json_decode($jsonData, true);
        $response = $this->delete('/api/orders/' . $expected_order['id'], $data);

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
        $response = $this->delete('/api/orders/' . 999, $data);

        // Assert response status
        $response->assertStatus(404);
    }
    public function test_getByUserId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $expected_user = User::where('id', Order::take(1)->first()['user_id'])->take(1)->first();
        $user_id = $expected_user['id'];
        $expected_orders = Order::where('user_id', $user_id)->get();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/orders-user/' . $user_id);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'orders' => [
                    '*' => [
                        'id',
                        'invitation' => 'id',
                        'theme' => 'id'
                    ],
                ]
            ],
        ]);
        // Assert count
        $expected_count = count($expected_orders);
        $received_orders = $response["data"]["orders"];
        $this->assertCount($expected_count, $received_orders, 'Data count not same');
        // Assert data integrity and consistency
        // for user
        // $this->assertEquals($response['data']['user']['id'], $user_id, 'Wedding ID not consistent');
        // for wish
        $integrityStatus = true;
        $consistencyStatus = true;
        $expectedStructureCount = 13;
        $expected_orders_ids = $expected_orders->map(fn ($wish) => $wish['id'])->toArray();
        foreach ($received_orders as $wish) {
            if (!in_array($wish['id'], $expected_orders_ids)) {
                $integrityStatus = false;
            }
            if (count($wish) != $expectedStructureCount) {
                $consistencyStatus = false;
            }
        }
        $this->assertTrue($integrityStatus, 'Orders IDs not consistent');
        $this->assertTrue($consistencyStatus, 'Orders Structures not consistent');
    }
    public function test_getByUserId_nonExistentUserId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/orders-user/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }

    public function test_payment_midtrans_callback()
    {
        $snapToken = $this->test_store();
        $order_id = explode(':',$snapToken)[1];
        $server_key = config('midtrans.server_key');
        $signature_key = hash("sha512", $order_id . $server_key);
        
        // assert before callback
        $order = Order::where('id',$order_id)->first();
        $payment = $order->payment;
        $this->assertEquals($order['status'],'UNPAID');
        $this->assertEquals($payment['transaction_status'],null);
        
        $data = [
            'order_id' => $order_id,
            'transaction_status' => 'capture',
            'signature_key' => $signature_key
        ];
        $response = $this->post('/api/midtrans-callback/', $data);
        // assert response status
        $response->assertStatus(200);
        
        // assert after callback
        $order = Order::where('id',$order_id)->first();
        $payment = $order->payment;
        $this->assertEquals($order['status'],'PAID');
        $this->assertEquals($payment['transaction_status'],$data['transaction_status']);

        // Wrong input
        $data = [
            'order_id' => $order_id,
            'transaction_status' => 'capture',
            'signature_key' => 'wrong'
        ];
        $response = $this->post('/api/midtrans-callback/', $data);
        // assert response status
        $response->assertStatus(422);
    }
}

<?php

namespace Tests\Unit;

use App\Models\Invitation;
use App\Models\Wedding;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class WeddingTest extends TestCase
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

    public function test_show_byOrderId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $wedding = Wedding::take(1)->first();
        $invitation = Invitation::where('id', $wedding['invitation_id'])->first();
        $order = Order::where('id', $invitation['order_id'])->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/weddings-order/' . $order['id']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'order' => [
                    'id',
                    'user' => 'id',
                    'package' => 'id',
                    'theme' => 'id',
                    'payment' => 'id',
                    'invitation' => [
                        'id',
                        'type' => 'id',
                        'wedding' => [
                            'id',
                            'groom' => 'id',
                            'bride' => 'id',
                            'wish' => ['*' => ['id']],
                            'gift' => ['*' => ['id']],
                            'event' => ['*' => ['id']],
                            'love_story' => ['*' => ['id']],
                            'gallery' => ['*' => ['id']]
                        ],
                    ],
                ]
            ],
        ]);
        // Assert data integrity
        // TODO...
    }
    public function test_show_byOrderId_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/weddings-order/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
    public function test_update_byOrderId()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $wedding = Wedding::take(1)->first();
        $invitation = Invitation::where('id', $wedding['invitation_id'])->first();
        $order = Order::where('id', $invitation['order_id'])->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{
            "slug": "ContohSlug",
            "title": "Judul Wedding",
            "location": "Lokasi Wedding",
            "location_gmap": "Lokasi Google Maps",
            "rekening_gift": "Nomor Rekening Gift",
            "groom_name": "Nama Groom",
            "groom_father": "Ayah Groom",
            "groom_mother": "Ibu Groom",
            "groom_address": "Alamat Groom",
            "groom_instagram": "Instagram Groom",
            "groom_image": "URL Gambar Groom",
            "bride_name": "Nama Bride",
            "bride_father": "Ayah Bride",
            "bride_mother": "Ibu Bride",
            "bride_address": "Alamat Bride",
            "bride_instagram": "Instagram Bride",
            "bride_image": "URL Gambar Bride",
            "date_akad": "2023/12/01 14:00:00",
            "start_time_akad": "14:00:00",
            "end_time_akad": "16:00:00",
            "place_akad": "Tempat Akad",
            "date_resepsi": "2023/12/02 18:00:00",
            "start_time_resepsi": "18:00:00",
            "end_time_resepsi": "22:00:00",
            "place_resepsi": "Tempat Resepsi",
            "date_unduh_mantu": "2023/12/03 12:00:00",
            "start_time_unduh_mantu": "12:00:00",
            "end_time_unduh_mantu": "15:00:00",
            "place_unduh_mantu": "Tempat Unduh Mantu",
            "love_stories": [
                {
                "year": "Tahun 1",
                "story": "Story tahun 1",
                "image": "love_story_image1"
                },
                {
                "year": "Tahun 2",
                "story": "Story tahun 2",
                "image": "love_story_image2"
                },
                {
                "year": "Tahun 3",
                "story": "Story tahun 3",
                "image": "love_story_image3"
                }
            ],
            "galleries": [
                {
                "file": "URLImageGallery1"
                },
                {
                "file": "URLImageGallery2"
                },
                {
                "file": "URLImageGallery3"
                }
            ]
        }';
        $data = json_decode($jsonData,true);
        $response = $this->post('/api/weddings-order/' . $order['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'order' => [
                    'id',
                    'invitation' => [
                        'id',
                        'type' => 'id',
                        'wedding' => [
                            'id',
                            'groom' => 'id',
                            'bride' => 'id',
                            'event' => ['*' => ['id']],
                            'love_story' => ['*' => ['id']],
                            'gallery' => ['*' => ['id']]
                        ],
                    ],
                ]
            ],
        ]);
        // Assert data integrity
        // TODO...
        $this->assertNotEquals($wedding['updated_at'], $response['data']['order']['invitation']['wedding']['updated_at'], 'updated_at not updated');
    }
    public function test_update_byOrderId_nullData()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $wedding = Wedding::take(1)->first();
        $invitation = Invitation::where('id', $wedding['invitation_id'])->first();
        $order = Order::where('id', $invitation['order_id'])->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $jsonData = '{
            "slug": "",
            "title": "",
            "location": "",
            "location_gmap": "",
            "rekening_gift": "",
            "groom_name": "",
            "groom_father": "",
            "groom_mother": "",
            "groom_address": "",
            "groom_instagram": "",
            "groom_image": "",
            "bride_name": "",
            "bride_father": "",
            "bride_mother": "",
            "bride_address": "",
            "bride_instagram": "",
            "bride_image": "",
            "date_akad": "",
            "start_time_akad": "",
            "end_time_akad": "",
            "place_akad": "",
            "date_resepsi": "",
            "start_time_resepsi": "",
            "end_time_resepsi": "",
            "place_resepsi": "",
            "date_unduh_mantu": "",
            "start_time_unduh_mantu": "",
            "end_time_unduh_mantu": "",
            "place_unduh_mantu": "",
            "love_stories": [
                
            ],
            "galleries": [
                
            ]
        }';
        $data = json_decode($jsonData, true);
        $response = $this->post('/api/weddings-order/' . $order['id'], $data);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            // 'errors',
            'data' => [
                'order' => [
                    'id',
                    'invitation' => [
                        'id',
                        'type' => 'id',
                        'wedding' => [
                            'id',
                            'groom' => 'id',
                            'bride' => 'id',
                            'event' => ['*' => ['id']],
                            'love_story' => ['*' => ['id']],
                            'gallery' => ['*' => ['id']]
                        ],
                    ],
                ]
            ],
        ]);
        // Assert data integrity
        // TODO...
        $this->assertNotEquals($wedding['updated_at'], $response['data']['order']['invitation']['wedding']['updated_at'], 'updated_at not updated');
    }
    public function test_update_byOrderId_nonExistentId()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->post('/api/weddings-order/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
    public function test_show_byInvitationSlug()
    {
        // Seed data in test db
        $this->seed_silent();

        // Get expected data from db
        $wedding = Wedding::take(1)->first();
        $invitation = Invitation::where('id', $wedding['invitation_id'])->first();

        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/weddings-invitation/' . $invitation['slug']);

        // Assert response status and structure
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'invitation' => [
                    'id',
                    'wedding' => [
                        'id',
                        'groom' => ['id'],
                        'bride' => ['id'],
                        'wish' => ['*' => ['id']],
                        'gift' => ['*' => ['id']],
                        'event' => ['*' => ['id']],
                        'love_story' => ['*' => ['id']],
                        'gallery' => ['*' => ['id']]
                    ],
                    'order' => [
                        'id',
                        'package' => ['id'],
                    ]
                ],
                'package' => ['id'],
                'g_calendar'
            ],
        ]);
        // Assert data integrity
        // TODO...
    }
    public function test_show_byInvitationSlug_nonExistentInvitationSlug()
    {
        // Seed data in test db
        $this->seed_silent();


        // Mock authentication
        $user = $this->authenticateUser();

        // Call the API
        $response = $this->get('/api/weddings-invitation/' . 999);

        // Assert response status and structure
        $response->assertStatus(404);
    }
}

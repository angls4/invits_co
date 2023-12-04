<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use function PHPUnit\Framework\assertTrue;

class EndToEndTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */

    /**
     * This method is called before
     * any test of TestCase class executed
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        print "\nSETTING UP DATABASE\n";
        shell_exec('php artisan migrate --seed');
    }

    /**
     * This method is called after
     * all tests of TestCase class executed
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        shell_exec('php artisan migrate:reset');
        print "\nDESTROYED DATABASE\n";
        parent::tearDownAfterClass();
    }

    public function testRegisterLogoutLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Rayakan Cinta Tanpa Batas dengan Keindahan Teknologi');
            assertTrue($browser->seeLink('Login'));
            $browser->clickLink('Login')
                ->assertPathIs('/login');
            assertTrue($browser->seeLink('Daftar Sekarang!'));
            $browser->clickLink('Daftar Sekarang!')
                ->assertPathIs('/register');
            // First Name
            $browser->type('#first_name', 'Dusk');
            // Last Name
            $browser->type('#last_name', 'Test');
            // Phone
            $browser->type('#mobile', '123456789');
            // Email
            $email = 'dusk.test@example.com';
            $browser->type('#email', $email);
            // Password
            $password = '123123123';
            $browser->type('#password', $password);
            // Confirm Password
            $browser->type('#c_password', $password);
            // Submit the form
            $browser->press('Daftar');
            // Test auth
            $expected_user = User::where('email', $email)->first();
            $browser->assertPathIsNot('/register');
            $browser->assertPresent('#user-menu-button');
            $browser->press('#user-menu-button');
            $browser->clickLink('Logout');
            $browser->assertMissing('#user-menu-button');
            $browser->clickLink('Login')
                ->assertPathIs('/login');
            // Email
            $browser->type('#email', $email);
            // Password
            $browser->type('#password', $password);
            // Submit the form
            $browser->press('Masuk');
            $browser->assertPathIsNot('/login');
            $browser->assertPresent('#user-menu-button');
            $browser->press('#user-menu-button');
            $browser->clickLink('Logout');
        });
    }
    public function testSocialLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Rayakan Cinta Tanpa Batas dengan Keindahan Teknologi')
                ->clickLink('Login')
            ->assertPathIs('/login')
            ->assertSee('Masuk Melalui Google')
            ->clickLink('Masuk Melalui Google')
            ->assertPathBeginsWith('/login/')
            ->type('#email','dusk.test@example.com')
            ->press('Submit')
            ->assertPathIsNot('/login')
            ->assertPresent('#user-menu-button');
        });
    }
    public function testLandingPageItems(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Rayakan Cinta Tanpa Batas dengan Keindahan Teknologi')
                ->assertSee('Buat Undangan Anda')
                ->assertSee('Pelayanan Terbaik Kami')
                ->assertSee('Pilih Paket Terbaikmu')
                ->assertSee('Preset Memudahkan Kita')
                ->assertSee('Apa Kata Mereka Tentang Kami')
                ->assertSee('Fitur Kami dalam Membuat Undangan Elegan dan Luar Biasa')
                ->assertSee('Mari Lihat Klien Kami Sebelumnya')
                ->assertSee('Jadikan pernikahan Anda berharga dan semakin berkesan dengan layanan kami');
        });
    }
    public function testMakeOrderPayOrder(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Pesan Sekarang')
                ->clickLink('Pesan Sekarang')
                ->assertPathIs('/order')
                // ->click('h2:contains("Gold")')
                ->click('.grid.gap-4>a:nth-child(3)')
                ->assertPathBeginsWith('/order/theme')
                ->clickLink('Preview')
                ->clickLink('Buat Undangan')
                ->press('Bayar Sekarang')
                ->waitForDialog(10)
                ->assertDialogOpened('payment success!')
                ->acceptDialog()
                ->waitForLocation('/')
                ->assertPathIs('/')
                ;

        });
    }
    public function aaa(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Pesan Sekarang')
                ;      
        });
    }
    public function testNavigateToClientArea(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('#user-menu-button')
                    ->press('#user-menu-button')
                    ->assertSeeLink('Client Area')
                    ->clickLink('Client Area')
                    ->assertPathBeginsWith('/client')
                    ;
                
        });
    }
    public function testOrderListDetailEdit(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
                ->assertSee('Order List')
                ->click('tbody>tr>td:nth-child(6)>a')
                ->assertSee('Waktu Transaksi')
                ->back()
                ->click('tbody>tr>td:nth-child(7)>a')
                ->assertSee('Ubah')
                ->press('Ubah')
                ->waitForText('Simpan Perubahan',10)
                ->press('Simpan Perubahan')
                ->acceptDialog()
                // ->assertDialogOpened('Data berhasil diubah!')
                ->visit('/client/orders')
                ->assertSee('ACTIVE')
                ;
        });
    }
    public function testAddGuest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
                ->assertSee('ACTIVE')
                ->click('tbody>tr>td:nth-child(7)>a')
                // ->click('div.container.flex.items-center.py-3>div>a')
                ->clickLink('Tamu')
                ->assertSeeLink('Add New')
                ->clickLink('Add New')
                ->assertSee('Information about your guest')
                ->type('#name', 'John Doe')  // Replace 'John Doe' with the desired value
                ->type('#description', 'Some description')  // Replace 'Some description' with the desired value
                ->type('#address', '123 Main St')  // Replace '123 Main St' with the desired value
                ->type('#no_whats_app', '123456789')  // Replace '123456789' with the desired value
                ->type('#email', 'john.doe@example.com')  // Replace 'john.doe@example.com' with the desired value
                ->press('Add')
                ->waitForTextIn('table','John Doe')
                ->assertSee('John Doe')
                ;
        });
    }
    public function testBroadcastEditDeleteGuest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
            ->assertSee('ACTIVE')
            ->click('tbody>tr>td:nth-child(7)>a')
            ->clickLink('Tamu')
            ->assertSeeLink('Add New')
            ->check('#selectAllCheckbox')
            ->press('Broadcast')
            // ->assertSeeIn('button', 'Broadcast')
            ->press('Confirm')
            // ->assertSeeIn('button','Kirim')
            ->press('Kirim')
            ->waitForText('operasi berhasil',10)
            ->press('OK')
            ->click('a>.ph-pencil-simple')
            // ->assertSeeIn('button','Edit')
            ->press('Edit')
            ->acceptDialog()
            ->click('button>.ph-trash')
            // ->assertSeeIn('button', 'Hapus')
            ->press('Hapus')
            ->waitForText('operasi berhasil', 10)
            ->press('OK')
            ->assertNotPresent('tr>td')
            ;
        });
    }
    public function testPreviewItems(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
            ->click('tbody>tr>td:nth-child(7)>a')
            ->clickLink('Pratinjau');
            // Collect all tabs and grab the last one (recently opened).
            $window = collect($browser->driver->getWindowHandles())->last();

            // Switch to the new tab that contains the screenshot
            $browser->driver->switchTo()->window($window);
            $browser
            ->assertSee('Anak dari Bpk.')
            ->assertSee(('Unduh Mantu'))
            ->assertSee(('Lokasi'))
            ->assertSee(('Kisah Cinta Kita'))
            ->assertSee(('Gallery'))
            ->assertSeeLink(('Simpan acara ke kalender'))
            ->assertSee(('Simpan acara ke kalender'));
        });
    }
    public function testRsvp(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
            ->click('tbody>tr>td:nth-child(7)>a')
            ->clickLink('Pratinjau');
            // Collect all tabs and grab the last one (recently opened).
            $window = collect($browser->driver->getWindowHandles())->last();

            // Switch to the new tab that contains the screenshot
            $browser->driver->switchTo()->window($window);
            $browser
            ->assertSee(('Konfirmasi Kehadiranmu'))
            ->type('#nama','Dusk')
            ->type('#jumlah',2)
            ->select('#kehadiran','Hadir')
            ->press('Konfirmasi Kehadiran')
            ->acceptDialog()
            ;
        });
    }
    public function testWish(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
            ->click('tbody>tr>td:nth-child(7)>a')
            ->clickLink('Pratinjau');
            // Collect all tabs and grab the last one (recently opened).
            $window = collect($browser->driver->getWindowHandles())->last();

            // Switch to the new tab that contains the screenshot
            $browser->driver->switchTo()->window($window);
            $browser
                ->assertSee(('Wishes & Gifts'))
                ->type('#name', 'Dusk')
                ->type('#wish', "Test Wish")
                ->press('Kirim')
                // ->acceptDialog()
                ->assertSee('Test Wish');
        });
    }
    public function testGift(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
            ->click('tbody>tr>td:nth-child(7)>a')
            ->clickLink('Pratinjau');
            // Collect all tabs and grab the last one (recently opened).
            $window = collect($browser->driver->getWindowHandles())->last();

            // Switch to the new tab that contains the screenshot
            $browser->driver->switchTo()->window($window);
            $browser
                ->assertSee(('best gift'))
                ->press('Send now!')
                ->assertSee('Transfer ke')
                ->click('button>svg>path');
        });
    }
    public function testEditProfileEditPassword(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/client/orders')
                ->clickLink('Profile')
                ->assertSee('Ubah')
                ->press('Ubah')
                ->waitForText('Simpan Perubahan', 10)
                ->press('Simpan Perubahan')
                ->clickLink('Ubah Kata Sandi')
                ->waitForText('Edit Password')
                ->type('#old_password','123123123')
                ->type('#new_password','newpassword')
                ->type('#c_new_password','newpassword')
                ->press('Simpan')
                ->waitUntilMissingText('Edit Password')
                ->assertDontSee('Edit Password');
        });
    }
}

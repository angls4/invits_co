<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('rupiah', function ( $expression ) { 
            return "Rp. <?php echo number_format(" . $expression . ",0,',','.'); ?>";
        });

        Blade::directive('dateID', function ( $expression ) { 
            return "<?php echo \Carbon\Carbon::parse(" . $expression . ")->locale('id')->isoFormat('dddd, D MMMM Y'); ?>";
        });
    }
}

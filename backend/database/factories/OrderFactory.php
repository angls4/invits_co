<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\User;
use App\Models\Package;
use App\Models\Theme;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = collect(['PAID', 'UNPAID']);
        $user = User::inRandomOrder()->first();
        $package = Package::inRandomOrder()->first();
        $theme = Theme::where('package_id', '=', $package->id)->inRandomOrder()->first();

        while(!$theme){
            $package = Package::inRandomOrder()->first();
            $theme = Theme::where('package_id', '=', $package->id)->inRandomOrder()->first();
        }

        return [
            'status'            => $status->random(),
            'user_id'           => $user->id,
            'package_id'        => $package->id,
            'theme_id'          => $theme->id,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}

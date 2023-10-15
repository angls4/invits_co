<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Models
use App\Models\User;
use App\Models\InvitationType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = collect(['ACTIVE', 'INACTIVE', 'INCOMPLETE']);
        $user = User::inRandomOrder()->first();
        $invitation_type = InvitationType::inRandomOrder()->first();
        $slug = Str::slug($user->name, '-') . Str::random();
        $is_custom_domain = (bool)random_int(0, 1);
        ($is_custom_domain) ? $custom_domain = 'Link' : $custom_domain = null;  

        return [
            'user_id'               => $user->id,
            'invitation_type_id'    => $invitation_type->id,
            'status'                => $status->random(),
            'slug'                  => $slug,
            'is_custom_domain'      => $is_custom_domain,
            'custom_domain'         => $custom_domain,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ];
    }
}

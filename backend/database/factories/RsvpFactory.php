<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\Invitation;
use App\Models\Guest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rsvp>
 */
class RsvpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invitation = Invitation::inRandomOrder()->first();
        $guest = Guest::inRandomOrder()->first();

        return [
            "name"          => $guest->name,
            "amount_guest"  => (int)random_int(0, 20),
            "is_attend"     => (bool)random_int(0, 1),
            "invitation_id" => $invitation->id,
            "guest_id"      => $guest->id,
        ];
    }
}

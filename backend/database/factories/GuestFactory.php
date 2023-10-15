<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\Invitation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invitation = Invitation::inRandomOrder()->first();

        return [
            "name" => $this->faker->name(),
            "description" => substr($this->faker->text(25), 0, -1),
            "is_invited" => (bool)random_int(0, 1),
            "address" => $this->faker->paragraph,
            "no_whats_app" => $this->faker->e164PhoneNumber,
            "email" => $this->faker->email,
            "invitation_id" => $invitation->id,
        ];
    }
}

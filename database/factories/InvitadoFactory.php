<?php

namespace Database\Factories;


use App\Models\Invitado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InvitadoFactory extends Factory
{
    protected $model = Invitado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'nombre' => fake()->name(),
            'telefono' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'nif' => fake()->randomNumber(8),
            'numero_personas' => fake()->numberBetween(1, 10),
            'observaciones' => fake()->text(),
            'asistencia_confirmada' => fake()->boolean(),
        ];
    }
}

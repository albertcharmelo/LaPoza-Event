<?php

namespace Database\Factories;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{

    protected $model = Evento::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => fake()->name(),
            'email_organizador' => fake()->email(),
            'telefono_organizador' => fake()->phoneNumber(),
            'numero_invitados' => fake()->numberBetween(6, 100),
            'ingreso_bruto' => fake()->numberBetween(1000, 100000),
            'fecha' => fake()->date(),
        ];
    }
}

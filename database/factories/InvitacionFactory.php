<?php

namespace Database\Factories;


use App\Models\Invitacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitacion>
 */
class InvitacionFactory extends Factory
{
    protected $model = Invitacion::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $array_menus = ['Menu Fijo con Precio', 'Menu Fijo sin Precio', 'Menu a Elegir con Precio', 'Menu a Elegir sin Precio'];
        return [
            'titulo' => fake()->text(),
            'texto' => fake()->text(),
            'imagen' => fake()->imageUrl(960, 680, 'party', true),
            'tipo_menu' => fake()->randomElement($array_menus),
            'creado_por' => User::get()->first()->id,
            'evento_id' => fake()->numberBetween(1, 10),
        ];
    }
}

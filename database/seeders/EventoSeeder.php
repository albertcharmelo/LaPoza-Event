<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\Invitacion;
use App\Models\Invitado;
use Database\Factories\InvitadosFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Evento::factory()->count(20)
            ->has(
                Invitacion::factory()->count(1)
                    ->state(function (array $attributes, Evento $evento) {
                        return ['evento_id' => $evento->id];
                    })
                    ->has(Invitado::factory()->count(15)->state(function (array $attributes, Invitacion $invitacion) {
                        return [
                            'invitacion_id' => $invitacion->id,
                            'evento_id' => $invitacion->evento_id
                        ];
                    }), 'invitados'),
                'invitacion'
            )
            ->create();
    }
}

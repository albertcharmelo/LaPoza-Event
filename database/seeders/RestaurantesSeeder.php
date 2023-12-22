<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $restaurants = [
            ['nombre' => 'LaPoza Boadilla'],
            ['nombre' => 'Lapoza Getafe'],
            ['nombre' => 'LaPoza Leganés'],
            ['nombre' => 'LaPoza Sky - Sala de Eventos'],
            ['nombre' => 'LaPoza Vip - Sala de Eventos'],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurante::create($restaurant);
        }
    }
}

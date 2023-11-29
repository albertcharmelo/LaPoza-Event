<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class ArtisanController extends Controller
{
    public function migrate()
    {
        # Se ejecutra una sola vez para instalar el servidor
        $output = new BufferedOutput();
        Artisan::call('migrate:fresh', [], $output);
        Artisan::call('migrate', [], $output);
        Artisan::call('db:seed', [], $output);

        $outputText = $output->fetch();

        echo '<pre>' . $outputText . '</pre>';
    }
}

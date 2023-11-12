<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Ramsey\Uuid\Uuid;

class QrController extends Controller
{
    public static function generate()
    {
        // create a qr code and save it to a directory
        $ramdomFilename = Uuid::uuid4();
        $path = public_path("images/qrcodes/$ramdomFilename.svg");
        $qrCode = QrCode::format('svg')->size(400)
            ->color(253, 104, 62)
            ->generate('hola munndo', $path);
        return response()->download($path);
    }
}

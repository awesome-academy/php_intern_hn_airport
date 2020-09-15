<?php

namespace App\Http\Controllers\ViewShare;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ViewShareController extends Controller
{
    public function __construct()
    {
        $carTypes = CarType::all();
        $provinces = Province::has('provinceAirports')->get();

        View::share([
            'carTypes' => $carTypes,
            'provinces' => $provinces,
        ]);
    }
}

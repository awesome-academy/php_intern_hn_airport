<?php

namespace App\Http\Controllers\ViewShare;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use App\Models\Province;
use App\Repositories\CarType\CarTypeRepositoryInterface;
use App\Repositories\Province\ProvinceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ViewShareController extends Controller
{
    public function __construct(
        CarTypeRepositoryInterface $carTypeRepo,
        ProvinceRepositoryInterface $provinceRepo
    ) {
        $carTypes = $carTypeRepo->getAll();
        $provinces = $provinceRepo->getProvinceHasAiport();

        View::share([
            'carTypes' => $carTypes,
            'provinces' => $provinces,
        ]);
    }
}

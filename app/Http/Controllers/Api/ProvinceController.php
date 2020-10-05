<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Repositories\Province\ProvinceRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ProvinceController extends Controller {
    protected $provinceRepo;

    public function __construct(
        ProvinceRepositoryInterface $provinceRepo
    ) {
        $this->provinceRepo = $provinceRepo;
    }

    public function searchByName(Request $request) {
        try {
            $cityName = $request->city;
            $provinceId = $this->provinceRepo->searchByName($cityName);

            if ($provinceId) {
                return response()->json($provinceId, 200);
            }

            return response()->json('', 500);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}

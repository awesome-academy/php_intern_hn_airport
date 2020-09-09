<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Exception;
use Illuminate\Http\Request;

class ProvinceController extends Controller {
    public function searchByName(Request $request) {
        try {
            $cityName = $request->city;
            $provinceId = Province::where('name', 'like', '%' . $cityName . '%')->first();

            if ($provinceId) {
                return response()->json($provinceId, 200);
            }

            return response()->json('', 500);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}

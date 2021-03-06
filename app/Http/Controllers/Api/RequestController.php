<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestPost;
use App\Http\Requests\StoreRequestWebPost;
use App\Repositories\ConfigBasic\ConfigBasicRepositoryInterface;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RequestController extends Controller
{   
    protected $configBasicRepo;

    public function __construct(
        ConfigBasicRepositoryInterface $configBasicRepo
    ) {
        $this->configBasicRepo = $configBasicRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function calculatePrice(StoreRequestPost $request) {
        try {
            $update = false;
            $update = $request->budget != config('constance.const.zero');
            
            $pickupLocation = $request->pickup_location;
            $dropoffLocation = $request->dropoff_location;
            $carTypeId = $request->car_type_id;
            $provinceAirportId = $request->province_airport_id;
            $time = date(config('constance.datetime'), strtotime($request->pickup));
            $hour = date(config('constance.hour'), strtotime($time));

            $origins = "";
            $destinations = "";
            foreach ($pickupLocation as $pickupPoint) {
                $origins .= $pickupPoint . "|";
            }
            foreach ($dropoffLocation as $dropoffPoint) {
                $destinations .= $dropoffPoint . "|";
            }
            $numPickup = count($pickupLocation);
            $distance = calculateDistance($pickupLocation, $dropoffLocation);

            if (function_exists('calculatePrice')) {
                $budget = calculatePrice($distance, $carTypeId, $provinceAirportId, $hour, $numPickup, $this->configBasicRepo);
                $budget = round($budget, config('constance.const.format_money'));

                if ($update) {
                    $data = [
                        "title" => trans('contents.common.alert.title.calculate_price_update_success'),
                        "message" => trans('contents.common.alert.message.calculate_price_update_success', ['budget' => $budget]),
                        "budget" => $budget,
                    ];
                } else {
                    $data = [
                        "title" => trans('contents.common.alert.title.calculate_price_success'),
                        "message" => trans('contents.common.alert.message.calculate_price_success', ['budget' => $budget]),
                        "budget" => $budget,
                    ];
                }
                
                if ($budget != config('constance.const.zero')) {
                    return response()->json($data, 200);
                } else {
                    return response()->json(trans('contents.common.alert.message.calculate_price_fail'), 500);
                }
            } else {
                return response()->json(trans('contents.common.alert.message.calculate_price_fail'), 500);
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}

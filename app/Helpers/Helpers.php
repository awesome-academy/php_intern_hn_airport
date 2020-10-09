<?php

use App\Models\CarType;
use App\Repositories\ConfigBasic\ConfigBasicRepositoryInterface;
use GuzzleHttp\Client;

if (!function_exists('calculatePrice')) {
    function calculatePrice(
        $distance, 
        $carTyeId, 
        $provinceAirportId, 
        $hour, 
        $numPickup, 
        ConfigBasicRepositoryInterface $configBasicRepo
    ) {
        $budget = 0;
    
        $carType = CarType::findOrFail($carTyeId);
        $carType = $carType->type;

        $coefficient = $configBasicRepo->findCost($distance, $carType);

        if ($coefficient) {
            $coefficient = $coefficient->cost;
            $budget = $coefficient * $distance;
            $budget =  $budget + $budget / config('constance.const.percent') * config('constance.const.fee_basic');
            if ((int)$hour > config('constance.time.condition_1') || (int)$hour < config('constance.time.condition_1')) {
                $budget = $budget + $budget / config('constance.const.percent') * config('constance.const.bonus_basic');
            }
        
            return $budget;
        }

        return $budget;
    }
}

if (!function_exists('calculateDistance')) {
    function calculateDistance($pickupLocation, $dropoffLocation)
    {
        $distance = 0;
        $numPickup = count($pickupLocation);
        $numDropoff = count($dropoffLocation);
        if ($numPickup > config('constance.const.one')) {
            for ($i = 0; $i < $numPickup - config('constance.const.one'); $i++) { 
                $origins = $pickupLocation[$i];
                $j = $i + 1;
                $destinations = $pickupLocation[$j];
                $client = new Client();
                $response = $client->get(config('constance.google_map') . $origins . 
                    '&destinations=' . $destinations . '&key=' . env('GOOGLE_API_KEY'));
                $json = json_decode($response->getBody(), true);
                $distance += (int) $json['rows'][0]['elements'][0]['distance']['value'] / config('constance.const.m_to_km');
            }
        }
        $origins = $pickupLocation[$numPickup - config('constance.const.one')];
        $destinations = $dropoffLocation[config('constance.const.zero')];
        $client = new Client();
        $response = $client->get(config('constance.google_map') . $origins . 
            '&destinations=' . $destinations . '&key=' . env('GOOGLE_API_KEY'));
        $json = json_decode($response->getBody(), true);
        $distance += (int) $json['rows'][0]['elements'][0]['distance']['value'] / config('constance.const.m_to_km');
        if ($numDropoff > config('constance.const.one')) {
            for ($i = 0; $i < $numDropoff - config('constance.const.one'); $i++) { 
                $origins = $dropoffLocation[$i];
                $j = $i + 1;
                $destinations = $dropoffLocation[$j];
                $client = new Client();
                $response = $client->get(config('constance.google_map') . $origins . 
                    '&destinations=' . $destinations . '&key=' . env('GOOGLE_API_KEY'));
                $json = json_decode($response->getBody(), true);
                $distance += (int) $json['rows'][0]['elements'][0]['distance']['value'] / config('constance.const.m_to_km');
            }
        }

        return $distance;
    }
}


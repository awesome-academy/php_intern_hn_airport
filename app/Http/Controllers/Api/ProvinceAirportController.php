<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProvinceAirport;
use App\Repositories\ProvinceAirport\ProvinceAirportRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ProvinceAirportController extends Controller
{
    protected $provinceAirportRepo;

    public function __construct(
        ProvinceAirportRepositoryInterface $provinceAirportRepo
    ) {
        $this->provinceAirportRepo = $provinceAirportRepo;
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
     * Get airport in province.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $provinceAirport = $this->provinceAirportRepo->find($id);
            $data = [
                'provinceAirport' => $provinceAirport,
            ];
            
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
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
}

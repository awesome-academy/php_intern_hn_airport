<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\HostDetail;
use App\Models\Request as ModelsRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == config('constance.status.new')) {
                $requests = ModelsRequest::join('province_airports', 'province_airports.id', '=', 'requests.province_airport_id')
                    ->join('host_details', function($query) {
                        $query->on('host_details.province_id', 'province_airports.province_id')
                            ->on('host_details.car_type_id', 'requests.car_type_id');
                    })
                    ->select('requests.*')
                    ->with([
                        'requestDestinations',
                        'carTypes',
                    ])
                    ->get();

                return DataTables::of($requests)
                    ->setRowData([
                        'car_types' => function($request) 
                        {
                            return ($request->carTypes->type) . ' ' . trans('contents.common.form.seat');
                        },
                        'pickup_location' => function($request) 
                        {
                            foreach ($request->requestDestinations as $requestDestination) {
                                if ($requestDestination->type == config('constance.const.request_pickup')) {
                                    return $requestDestination;
                                }
                            }
                        },
                        'dropoff_location' => function($request) 
                        {
                            foreach ($request->requestDestinations as $requestDestination) {
                                if ($requestDestination->type == config('constance.const.request_dropoff')) {
                                    return $requestDestination;
                                }
                            }
                        },
                    ])
                    ->addColumn('action', function ($user) 
                    {
                        return '<a href="' . route('host.requests.show', $user->id) . '" class="btn btn-warning btn-detail">
                        <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        return view('host.listRequest.index');
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
        try {
            $requestDetail = ModelsRequest::with([
                    'user',
                    'carTypes',
                    'requestDestinations',
                    'requestCustomer',
                ])
                ->findOrFail($id);

            return view('host.requestDetail.index', compact('requestDetail'));
        } catch (Exception $e) {
            return view('404');
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

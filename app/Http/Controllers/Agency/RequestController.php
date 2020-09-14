<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestPost;
use App\Models\CarType;
use App\Models\Province;
use App\Models\Request as ModelsRequest;
use App\Models\RequestDestination;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class RequestController extends Controller
{
    /**
     * Display a listing RequestControllerof the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == config('constance.status.new')) {
                $requests = ModelsRequest::where([
                        'user_id'=> Auth::user()->id,
                        'status' => config('constance.const.request_new')
                    ])
                    ->with([
                        'carTypes',
                        'requestDestinations'
                    ])
                    ->get();

                return Datatables::of($requests)
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
                        return '<a href="' . route('agency.requests.show', $user->id) . '" class="btn btn-warning btn-detail">
                            <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>
                            <button type="button" class="btn btn-danger btn-delete-request">
                            <i class="fa fa-trash"></i>' . trans('contents.common.table.delete') . '</button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else if ($request->type == config('constance.status.cancel')) {
                $requests = ModelsRequest::onlyTrashed()
                    ->where('user_id', Auth::user()->id)
                    ->with('carTypes')
                    ->with('requestDestinations')
                    ->get();
                
                return Datatables::of($requests)
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
                        return '<a href="' . route('agency.requests.show', $user->id) . '" class="btn btn-warning btn-detail">
                            <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        return view('agency.listRequest.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agency.createRequest.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestPost $request)
    {   
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['pickup'] = date(config('constance.datetime'), strtotime($request->pickup));
        $input['status'] = config('constance.const.request_new');
        
        $createRequest = ModelsRequest::create($input);
        if ($createRequest) {
            $requestId = $createRequest->id;
            $pickup_location = $request->get('pickup_location');
            $dropoff_location = $request->get('dropoff_location');
            for ($i = 0; $i < count($pickup_location); $i++) {
                $requestDestination = new RequestDestination();
                $requestDestination->request_id = $requestId;
                $requestDestination->location = $pickup_location[$i];
                $requestDestination->type = config('constance.const.request_pickup');
                $requestDestination->save();
            }
            for ($i = 0; $i < count($dropoff_location); $i++) {
                $requestDestination = new RequestDestination();
                $requestDestination->request_id = $requestId;
                $requestDestination->location = $dropoff_location[$i];
                $requestDestination->type = config('constance.const.request_dropoff');
                $requestDestination->save();
            }

            return response()->json(trans('contents.common.alert.message.create_request_success'), 201);
        } else {
            return response()->json(trans('contents.common.alert.message.create_request_fail'), 500);
        }
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
            $requestDetail = ModelsRequest::withTrashed()
                ->with(['carTypes', 
                    'provinceAirports', 
                    'requestDestinations',
                    'provinceAirports.provinces'
                ])
                ->findOrFail($id);
            return view('agency.requestDetail.index', compact('requestDetail'));   
        } catch (Exception $th) {
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
    public function update(StoreRequestPost $request, $id)
    {
        $checkRequest = ModelsRequest::findOrFail($id);
        if ($checkRequest->status == config('constance.const.request_new')) {
            $input = $request->all();
            $input['status'] = config('constance.const.request_new');
            $input['pickup'] = date('Y-m-d H:i:s', strtotime($request->pickup));
            $checkRequest->update($input);
            RequestDestination::where('request_id', $id)->delete();

            $pickup_location = $request->get('pickup_location');
            $dropoff_location = $request->get('dropoff_location');
            for ($i = 0; $i < count($pickup_location); $i++) {
                $requestDestination = new RequestDestination();
                $requestDestination->request_id = $id;
                $requestDestination->location = $pickup_location[$i];
                $requestDestination->type = config('constance.const.request_pickup');
                $requestDestination->save();
            }
            for ($i = 0; $i < count($dropoff_location); $i++) {
                $requestDestination = new RequestDestination();
                $requestDestination->request_id = $id;
                $requestDestination->location = $dropoff_location[$i];
                $requestDestination->type = config('constance.const.request_dropoff');
                $requestDestination->save();
            }
            
            return response()->json(trans('contents.common.alert.message.update_request_success'), 200);
        } else {
            return response()->json(trans('contents.common.alert.message.update_request_failed'), 500);
        }
        try {
            
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $checkRequest = ModelsRequest::findOrFail($id);
            if ($checkRequest->status != config('constance.const.request_new')) {
                return response()->json(trans('contents.common.alert.message.delete_request_fail'), 500);
            }
            $checkRequest->update(['status' => config('constance.const.request_cancel')]);
            $checkRequest->delete();

            return response()->json(trans('contents.common.alert.message.delete_request_success'), 200);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}

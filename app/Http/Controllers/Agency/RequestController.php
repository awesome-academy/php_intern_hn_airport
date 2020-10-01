<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Http\Requests\StoreRequestPost;
use App\Models\CarType;
use App\Models\Province;
use App\Models\Request as ModelsRequest;
use App\Models\RequestDestination;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\RequestDestination\RequestDestinationRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class RequestController extends ViewShareController
{
    protected $requestRepo;
    protected $viewShare;
    protected $requestDestinationRepo;

    public function __construct(
        RequestRepositoryInterface $requestRepo, 
        RequestDestinationRepositoryInterface $requestDestinationRepo,
        ViewShareController $viewShare
    ) {
        $this->requestRepo = $requestRepo;
        $this->requestDestinationRepo = $requestDestinationRepo;
        $this->viewShare = $viewShare;
    }
    
    /**
     * Display a listing RequestControllerof the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestNew = $this->requestRepo->getRequestNew();
        $requestCancel = $this->requestRepo->getRequestCancel();

        return view('agency.listRequest.index', compact('requestNew', 'requestCancel'));
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
        $input['user_id'] = Auth::id();
        $input['pickup'] = date(config('constance.datetime'), strtotime($request->pickup));
        $input['status'] = config('constance.const.request_new');

        $createRequest = $this->requestRepo->create($input);
        if ($createRequest) {
            $requestId = $createRequest->id;
            $pickup_location = $request->get('pickup_location');
            $dropoff_location = $request->get('dropoff_location');
            for ($i = 0; $i < count($pickup_location); $i++) {
                $inputPickup = [];
                $inputPickup['request_id'] = $requestId;
                $inputPickup['location'] = $pickup_location[$i];
                $inputPickup['type'] = config('constance.const.request_pickup');

                $this->requestDestinationRepo->create($inputPickup);
            }
            for ($i = 0; $i < count($dropoff_location); $i++) {
                $inputPickup = [];
                $inputPickup['request_id'] = $requestId;
                $inputPickup['location'] = $dropoff_location[$i];
                $inputPickup['type'] = config('constance.const.request_dropoff');
                
                $this->requestDestinationRepo->create($inputPickup);
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
            $requestDetail = $this->requestRepo->find($id);
            return view('agency.requestDetail.index', compact('requestDetail'));   
        } catch (Exception $th) {
            return view('404');
        }
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
        try {
            $input = $request->all();
            $input['status'] = config('constance.const.request_new');
            $input['pickup'] = date('Y-m-d H:i:s', strtotime($request->pickup));
            $this->requestRepo->update($id, $input);

            $this->requestDestinationRepo->delete($id);

            $pickup_location = $request->get('pickup_location');
            $dropoff_location = $request->get('dropoff_location');
            for ($i = 0; $i < count($pickup_location); $i++) {
                $inputPickup = [];
                $inputPickup['request_id'] = $id;
                $inputPickup['location'] = $pickup_location[$i];
                $inputPickup['type'] = config('constance.const.request_pickup');

                $this->requestDestinationRepo->create($inputPickup);
            }
            for ($i = 0; $i < count($dropoff_location); $i++) {
                $inputPickup = [];
                $inputPickup['request_id'] = $id;
                $inputPickup['location'] = $dropoff_location[$i];
                $inputPickup['type'] = config('constance.const.request_dropoff');
                
                $this->requestDestinationRepo->create($inputPickup);
            }
            
            return response()->json(trans('contents.common.alert.message.update_request_success'), 200);
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
            $this->requestRepo->delete($id);

            return response()->json(trans('contents.common.alert.message.delete_request_success'), 200);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}

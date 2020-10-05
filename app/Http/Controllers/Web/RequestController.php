<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Http\Requests\StoreRequestPost;
use App\Http\Requests\StoreRequestWebPost;
use App\Models\CarType;
use App\Models\Province;
use App\Models\Request as ModelsRequest;
use App\Models\RequestCustomer;
use App\Models\RequestDestination;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\RequestCustomer\RequestCustomerRepositoryInterface;
use App\Repositories\RequestDestination\RequestDestinationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RequestController extends ViewShareController
{   
    protected $viewShare;
    protected $requestRepo;
    protected $requestCustomerRepo;
    protected $requestDestinationRepo;

    public function __construct(
        ViewShareController $viewShare,
        RequestRepositoryInterface $requestRepo,
        RequestCustomerRepositoryInterface $requestCustomerRepo,
        RequestDestinationRepositoryInterface $requestDestinationRepo
    ) {
        $this->viewShare = $viewShare;
        $this->requestRepo = $requestRepo;
        $this->requestCustomerRepo = $requestCustomerRepo;
        $this->requestDestinationRepo = $requestDestinationRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.index');
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
    public function store(StoreRequestWebPost $request)
    {
        $input = $request->all();

        $input['pickup'] = date(config('constance.datetime'), strtotime($request->pickup));
        $input['status'] = config('constance.const.request_new');;

        $createRequest = $this->requestRepo->create($input);
        if ($createRequest) {
            $requestId = $createRequest->id;
            $input['request_id'] = $requestId;
            $requestCustomer = $this->requestCustomerRepo->create($input);

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
                $requestDestination = new RequestDestination();
                $requestDestination->request_id = $requestId;
                $requestDestination->location = $dropoff_location[$i];
                $requestDestination->type = config('constance.const.request_dropoff');
                $requestDestination->save();

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

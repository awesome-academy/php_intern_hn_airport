<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractDriverPost;
use App\Models\Contract;
use App\Models\ContractDriver;
use App\Models\HostDetail;
use App\Models\Request as ModelsRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                    ->where('status', config('constance.const.request_new'))
                    ->with([
                        'requestDestinations',
                        'carTypes',
                    ])
                    ->distinct()
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
    public function update(StoreContractDriverPost $request, $id)
    {
        try {
            DB::beginTransaction();
            $requestDetail = ModelsRequest::findOrFail($id);
            $inputContract = [];
            $inputContract['request_id'] = $id;
            $inputContract['supplier_id'] = Auth::user()->id;
            $inputContract['pickup'] = $requestDetail->pickup;
            $inputContract['status'] = config('constance.const.contract_new');
            $contract = Contract::create($inputContract);

            if ($contract) {
                $requestDetail->update(['status' => config('constance.const.request_to_contract')]);
                $inputContractDriver = $request->all();
                $path = Storage::putFile(config('constance.image.contract'), $request->file('avatar'));
                $path = str_replace("public", "", $path);
                $inputContractDriver['avatar'] = $path;
                $inputContractDriver['contract_id'] = $contract->id;
                $contractDriver = ContractDriver::create($inputContractDriver);
                if ($contractDriver) {
                    alert()->success(trans('contents.common.alert.title.create_contract_success'), trans('contents.common.alert.message.create_contract_success'));
                } else {
                    alert()->error(trans('contents.common.alert.title.create_contract_fail'), trans('contents.common.alert.message.create_contract_fail'));
                }
                DB::commit();

                return redirect()->route('host.contracts.index');
            }
        } catch (Exception $e) {
            DB::rollBack();
            
            return view('404');
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
        //
    }
}

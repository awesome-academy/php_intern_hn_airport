<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractDriverPost;
use App\Http\Requests\UpdateContractDriverPost;
use App\Models\Contract;
use App\Models\ContractDriver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ContractController extends Controller
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
                $contracts =  Contract::where([
                    'supplier_id' => Auth::user()->id,
                    'status' => config('constance.const.request_new')
                ])
                ->with([
                    'request.carTypes',
                    'request.requestDestinations',
                ])
                ->get();

                return DataTables::of($contracts)
                    ->setRowData([
                        'car_types' => function($contract) 
                        {
                            return ($contract->request->carTypes->type) . ' ' . trans('contents.common.form.seat');
                        },
                        'pickup_location' => function($contract) 
                        {
                            foreach ($contract->request->requestDestinations as $requestDestination) {
                                if ($requestDestination->type == config('constance.const.request_pickup')) {
                                    return $requestDestination;
                                }
                            }
                        },
                        'dropoff_location' => function($contract) 
                        {
                            foreach ($contract->request->requestDestinations as $requestDestination) {
                                if ($requestDestination->type == config('constance.const.request_dropoff')) {
                                    return $requestDestination;
                                }
                            }
                        },
                    ])
                    ->addColumn('action', function ($contract) 
                    {
                        return '<a href="' . route('host.contracts.show', $contract->id) . '" class="btn btn-warning btn-detail">
                            <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>
                            <button type="button" class="btn btn-danger btn-delete-contract">
                            <i class="fa fa-trash"></i>' . trans('contents.common.table.delete') . '</button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else if ($request->type == config('constance.status.cancel')) {
                $contracts = Contract::onlyTrashed()
                    ->where('supplier_id', Auth::user()->id)
                    ->with([
                        'request.carTypes',
                        'request.requestDestinations'
                    ])
                    ->get();
                
                return Datatables::of($contracts)
                    ->setRowData([
                        'car_types' => function($contract) 
                        {
                            return ($contract->request->carTypes->type) . ' ' . trans('contents.common.form.seat');
                        },
                        'pickup_location' => function($contract) 
                        {
                            foreach ($contract->request->requestDestinations as $requestDestination) {
                                if ($requestDestination->type == config('constance.const.request_pickup')) {
                                    return $requestDestination;
                                }
                            }
                        },
                        'dropoff_location' => function($contract) 
                        {
                            foreach ($contract->request->requestDestinations as $requestDestination) {
                                if ($requestDestination->type == config('constance.const.request_dropoff')) {
                                    return $requestDestination;
                                }
                            }
                        },
                    ])
                    ->addColumn('action', function ($contract) 
                    {
                        return '<a href="' . route('host.contracts.show', $contract->id) . '" class="btn btn-warning btn-detail">
                            <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } 

        return view('host.listContract.index');
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
            $contractDetail = Contract::withTrashed()
                ->with([
                    'request.requestDestinations',
                    'request.requestCustomer',
                    'contractDriver',
                ])
                ->findOrFail($id);
            return view('host.contractDetail.index', compact('contractDetail'));
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
    public function update(UpdateContractDriverPost $request, $id)
    {
        try {
            DB::beginTransaction();
            $contractDriver = ContractDriver::findOrFail($id);
            $input = $request->all();
            if ($request->hasFile('avatar')) {
                Storage::delete('public' . $contractDriver->avatar);
                $path = Storage::putFile(config('constance.image.contract'), $request->file('avatar'));
                $path = str_replace("public", "", $path);
                $input['avatar'] = $path;
            }
            $updateDriver = $contractDriver->update($input);

            if ($updateDriver) {
                alert()->success(trans('contents.common.alert.title.update_contract_success'), trans('contents.common.alert.message.update_contract_success'));
            } else {
                alert()->error(trans('contents.common.alert.title.update_contract_fail'), trans('contents.common.alert.message.update_contract_fail'));
            }
            DB::commit();

            return redirect()->back();
        } catch (\Throwable $th) {
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
        try {
            $checkContract = Contract::findOrFail($id);
            if ($checkContract->status != config('constance.const.contract_new')) {
                return response()->json(trans('contents.alert.message.delete_contract_fail'), 500);
            }
            $checkContract->update(['status' => config('constance.const.contract_cancel')]);
            $checkContract->delete();

            return response()->json(trans('contents.alert.message.delete_contract_success'), 200);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}

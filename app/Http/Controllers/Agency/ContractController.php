<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Request as ModelsRequest;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                $requests =  ModelsRequest::whereHas('contract', function(Builder $query) {
                    $query->where('status', config('constance.const.contract_new'));
                })
                ->with([
                    'contract',
                    'carTypes',
                    'requestDestinations',
                ])
                ->where([
                    'user_id' => Auth::user()->id,
                    'status' => config('constance.const.request_to_contract'),
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
                    ->addColumn('action', function ($request)
                    {
                        return '<a href="' . route('agency.contracts.show', $request->contract->id) . '" class="btn btn-warning btn-detail">
                            <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>
                            <button type="button" class="btn btn-danger btn-delete-contract">
                            <i class="fa fa-trash"></i>' . trans('contents.common.table.delete') . '</button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else if ($request->type == config('constance.status.cancel')) {
                $requests =  ModelsRequest::whereHas('contract', function(Builder $query) {
                    $query->where('status', config('constance.const.contract_cancel'))->withTrashed();
                })
                ->with([
                    'carTypes',
                    'requestDestinations',
                    'contract' => function($query) {
                        $query->where('status', config('constance.const.contract_cancel'))->withTrashed();
                    },
                ])
                ->where([
                    'user_id' => Auth::user()->id,
                    'status' => config('constance.const.request_to_contract'),
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
                    ->addColumn('action', function ($request) 
                    {
                        return '<a href="' . route('agency.contracts.show', $request->contract->id) . '" class="btn btn-warning btn-detail">
                            <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        return view('agency.listContract.index');
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
                
            return view('agency.contractDetail.index', compact('contractDetail'));
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

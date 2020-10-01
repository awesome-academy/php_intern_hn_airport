<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Http\Requests\StoreContractDriverPost;
use App\Http\Requests\UpdateContractDriverPost;
use App\Models\Contract;
use App\Models\ContractDriver;
use App\Models\Request as ModelsRequest;
use App\Repositories\Contract\ContractRepositoryInterface;
use App\Repositories\ContractDriver\ContractDriverRepositoryInterface;
use App\Repositories\Request\RequestRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ContractController extends ViewShareController
{
    protected $viewShare;
    protected $contractRepo;
    protected $requestRepo;
    protected $contractDriverRepo;

    public function __construct(
        ViewShareController $viewShare,
        RequestRepositoryInterface $requestRepo,
        ContractRepositoryInterface $contractRepo,
        ContractDriverRepositoryInterface $contractDriverRepo
    ) {
        $this->viewShare = $viewShare;
        $this->requestRepo = $requestRepo;
        $this->contractRepo = $contractRepo;
        $this->contractDriverRepo = $contractDriverRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == config('constance.status.new')) {
                $contracts =  $this->contractRepo->getContractNewHost();

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
                        'budget' => function($contract)
                        {
                            return ($contract->request->budget) . ' ' . trans('contents.common.vnd');
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
                    ->addIndexColumn()
                    ->make(true);
            } else if ($request->type == config('constance.status.cancel')) {
                $contracts = $this->contractRepo->getContractCancelHost();
                
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
                        'budget' => function($contract)
                        {
                            return ($contract->request->budget) . ' ' . trans('contents.common.vnd');
                        },
                    ])
                    ->addColumn('action', function ($contract) 
                    {
                        return '<a href="' . route('host.contracts.show', $contract->id) . '" class="btn btn-warning btn-detail">
                            <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>';
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
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
            $contractDetail = $this->contractRepo->find($id);

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
            $contractDriver = $this->contractDriverRepo->find($id);
            $input = $request->except(['_token', '_method']);
            if ($request->hasFile('avatar')) {
                Storage::delete('public' . $contractDriver->avatar);
                $path = Storage::putFile(config('constance.image.contract'), $request->file('avatar'));
                $path = str_replace("public", "", $path);
                $input['avatar'] = $path;
            }
            $updateDriver = $this->contractDriverRepo->update($id, $input);

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
            $result = $this->contractRepo->delete($id);

            if ($result) {
                return response()->json(trans('contents.common.alert.message.delete_contract_success'), 200);
            } else {
                return response()->json(trans('contents.common.alert.message.update_contract_fail'), 500);
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Http\Requests\StoreContractDriverPost;
use App\Models\Contract;
use App\Models\ContractDriver;
use App\Models\HostDetail;
use App\Models\Request as ModelsRequest;
use App\Repositories\Contract\ContractRepository;
use App\Repositories\ContractDriver\ContractDriverRepositoryInterface;
use App\Repositories\Request\RequestRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RequestController extends ViewShareController
{
    protected $requestRepo;
    protected $contractRepo;
    protected $contractDriverRepo;
    protected $viewShare;

    public function __construct(
        RequestRepositoryInterface $requestRepo,
        ContractRepository $contractRepo,
        ContractDriverRepositoryInterface $contractDriverRepo,
        ViewShareController $viewShare    
    ) {
        $this->requestRepo = $requestRepo;
        $this->contractRepo = $contractRepo;
        $this->contractDriverRepo = $contractDriverRepo;
        $this->viewShare = $viewShare;
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
                $requests = $this->requestRepo->getRequestNewHost();

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
                        'budget' => function($request)
                        {
                            return ($request->budget) . ' ' . trans('contents.common.vnd');
                        },
                    ])
                    ->addColumn('action', function ($user) 
                    {
                        return '<a href="' . route('host.requests.show', $user->id) . '" class="btn btn-warning btn-detail">
                        <i class="fa fa-eye"></i>' . trans('contents.common.table.view') . '</a>';
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
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
            $requestDetail = $this->requestRepo->find($id);

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
            $requestDetail = $this->requestRepo->find($id);

            $inputContract = [];
            $inputContract['request_id'] = $id;
            $inputContract['supplier_id'] = Auth::id();
            $inputContract['pickup'] = $requestDetail->pickup;
            $inputContract['status'] = config('constance.const.contract_new');
            $contract = $this->contractRepo->create($inputContract);

            if ($contract) {
                $update = $this->requestRepo->update($id, ['status' => config('constance.const.request_to_contract')]);
                if ($update) {
                    $inputContractDriver = $request->all();
                    $path = Storage::putFile(config('constance.image.contract'), $request->file('avatar'));
                    $path = str_replace("public", "", $path);
                    $inputContractDriver['avatar'] = $path;
                    $inputContractDriver['contract_id'] = $contract->id;
                    $contractDriver = $this->contractDriverRepo->create($inputContractDriver);
                    if ($contractDriver) {
                        alert()->success(trans('contents.common.alert.title.create_contract_success'), trans('contents.common.alert.message.create_contract_success'));
                    } else {
                        alert()->error(trans('contents.common.alert.title.create_contract_fail'), trans('contents.common.alert.message.create_contract_fail'));
                    }
                    DB::commit();
                } else {
                    alert()->error(trans('contents.common.alert.title.create_contract_fail'), trans('contents.common.alert.message.create_contract_fail'));
                }

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

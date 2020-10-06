<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\StoreHostDetailPost;
use App\Http\Requests\StoreUserPost;
use App\Models\CarType;
use App\Models\HostDetail;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Repositories\HostDetail\HostDetailRepositoryInterface;
use App\Repositories\Province\ProvinceRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class HostController extends ViewShareController
{
    protected $roleRepo;
    protected $userRepo;
    protected $viewShare;
    protected $hostDetailRepo;
    protected $provinceRepo;

    public function __construct(
        RoleRepositoryInterface $roleRepo,
        UserRepositoryInterface $userRepo,
        HostDetailRepositoryInterface $hostDetailRepo,
        ProvinceRepositoryInterface $provinceRepo,
        ViewShareController $viewShare
    ) {
        $this->roleRepo = $roleRepo;
        $this->userRepo = $userRepo;
        $this->hostDetailRepo = $hostDetailRepo;
        $this->provinceRepo = $provinceRepo;
        $this->viewShare = $viewShare;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('host.register');
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
    public function store(StoreUserPost $request)
    {
        $role = $this->roleRepo->findRoleByName(config('constance.role.host'));

        $input = $request->all();
        $input['status'] = config('constance.const.user_active');;
        $input['avatar'] = config('constance.anonymous_user');
        $input['role_id'] = $role->id;
        $input['password'] = Hash::make($request->password);

        $user = $this->userRepo->create($input);

        if ($user) {
            alert()->success(trans('contents.common.alert.title.create_account_success'), trans('contents.common.alert.message.create_account_success'));
        } else {
            alert()->error(trans('contents.common.alert.title.create_account_fail'), trans('contents.common.alert.message.create_account_fail'));
        }
        
        return redirect()->route('host.getLogin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function getLogin() 
    {
        return view('host.login');
    }

    public function postLogin(LoginPostRequest $request) 
    {
        $role = $this->roleRepo->findRoleByName(config('constance.role.host'));
        $login = [
            'phone' => $request->phone,
            'password' =>$request->password,
            'status' => config('constance.const.user_active'),
            'role_id' => $role->id,
        ];
        if (Auth::attempt($login, $request->remember)) {
            alert()->success(trans('contents.common.alert.title.login_success'), trans('contents.common.alert.message.login_success'));

            return redirect()->route('host.contracts.index');
        } else {
            alert()->error(trans('contents.common.alert.title.login_failed'), trans('contents.common.alert.message.login_failed'));

            return redirect()->back();
        }
    }

    public function postLogout(Request $request)
    {   
        Auth::logout();
        alert()->success(trans('contents.common.alert.title.logout_success'), trans('contents.common.alert.message.logout_success'));

        return  redirect()->route('host.getLogin');
    }

    public function getDetail(Request $request) 
    {
        if ($request->ajax()) {
            $hostDetails = $this->hostDetailRepo->getAll();
            
            // return response()->json($hostDetails, 200);
            return Datatables::of($hostDetails)
                ->setRowData([
                    'car_types' => function($hostDetail) {
                        return ($hostDetail->carTypes->type).' '.trans('contents.common.form.seat');
                    },
                ])
                ->addColumn('action', function ($user) {
                    return '<button type="button" class="btn btn-warning btn-detail"><i class="fa fa-eye"></i>'.trans('contents.common.table.view').'</button>
                        <button type="button" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i>'.trans('contents.common.table.delete').'</button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $provinces = $this->provinceRepo->getAll();

        return view('host.hostDetail.index', compact('provinces'));
    }

    public function putDetail(StoreHostDetailPost $request, $id) 
    {
        try {
            $hostDetail = $this->hostDetailRepo->find($id);
            if ($hostDetail->province_id != $request->province_id || $hostDetail->car_type_id != $request->car_type_id) {
                return response()->json(trans('contents.common.alert.title.update_host_detail_fail'), 500);    
            } else {
                $update = $this->hostDetailRepo->update($id, ['quantity' => $request->quantity]);
                if ($update) {
                    return response()->json(trans('contents.common.alert.title.update_host_detail_success'), 200);
                } else {
                    return response()->json(trans('contents.common.alert.title.update_host_detail_fail'), 500);      
                }
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
    
    public function deleteDetail(Request $request, $id) 
    {
        try {
            $hostDetail = $this->hostDetailRepo->delete($id);
            if ($hostDetail) {
                return response()->json(trans('contents.common.alert.title.delete_host_detail_success'), 200);
            } else {
                return response()->json(trans('contents.common.alert.title.delete_host_detail_fail'), 500);      
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function postDetail(StoreHostDetailPost $request)
    {   
        $input['province_id'] = $request->province_id;
        $input['car_type_id'] = $request->car_type_id;
        $input['user_id'] = Auth::id();
        $quantity = $request->quantity;
        $hostDetail = $this->hostDetailRepo->createHostDetail($input, $quantity);
        if ($hostDetail->quantity != $quantity) {
            alert()->error(trans('contents.common.alert.title.create_host_detail_fail'), trans('contents.common.alert.message.create_host_detail_fail'));
        } else {
            alert()->success(trans('contents.common.alert.title.create_host_detail_success'), trans('contents.common.alert.message.create_host_detail_success'));
        }

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\StoreUserPost;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agency.register');
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
        $role = Role::where('name', 'agency')->select('id')->first();

        $input = $request->all();
        $input['status'] = config('constance.const.user_active');;
        $input['avatar'] = config('constance.anonymous_user');
        $input['password'] = Hash::make($request->password);
        $input['role_id'] = $role->id;

        $user = User::create($input);

        if ($user) {
            alert()->success(trans('contents.common.alert.title.create_account_success'), trans('contents.common.alert.message.create_account_success'));
        } else {
            alert()->error(trans('contents.common.alert.title.create_account_fail'), trans('contents.common.alert.message.create_account_fail'));
        }
        
        return redirect()->route('agency.getLogin');
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
        return view('agency.login');
    }

    public function postLogin(LoginPostRequest $request) 
    {
        $role = Role::where('name', config('constance.role.agency'))->first();
        $login = [
            'phone' => $request->phone,
            'password' =>$request->password,
            'status' => config('constance.const.user_active'),
            'role_id' => $role->id,
        ];
        if (Auth::attempt($login, $request->remember)) {
            alert()->success(trans('contents.common.alert.title.login_success'), trans('contents.common.alert.message.login_success'));

            return redirect()->route('requests.create');
        } else {
            alert()->error(trans('contents.common.alert.title.login_failed'), trans('contents.common.alert.message.login_failed'));

            return redirect()->back();
        }
    }

    public function postLogout(Request $request)
    {
        Auth::logout();
        alert()->success(trans('contents.common.alert.title.logout_success'), trans('contents.common.alert.message.logout_success'));
        
        return  redirect()->route('agency.getLogin');
    }
}

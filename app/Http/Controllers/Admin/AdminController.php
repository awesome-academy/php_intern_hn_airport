<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getLogin() {
        return view('admin.login');
    }

    public function postLogin(LoginPostRequest $request) {
        $role = Role::where('name', config('constance.role.admin'))->first();
        $login = [
            'phone' => $request->phone,
            'password' =>$request->password,
            'status' => config('constance.const.user_active'),
            'role_id' => $role->id,
        ];
        if (Auth::attempt($login, $request->remember)) {
            alert()->success(trans('contents.common.alert.title.login_success'), trans('contents.common.alert.message.login_success'));

            return redirect()->route('admin.dashboard.index');
        } else {
            alert()->error(trans('contents.common.alert.title.login_failed'), trans('contents.common.alert.message.login_failed'));

            return redirect()->back();
        }
    }

    public function postLogout() {
        Auth::logout();
        alert()->success(trans('contents.common.alert.title.logout_success'), trans('contents.common.alert.message.logout_success'));
        
        return redirect()->route('admin.getLogin');
    }
}

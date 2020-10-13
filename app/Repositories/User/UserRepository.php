<?php
namespace App\Repositories\User;

use App\Models\Request;
use App\Models\Role;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getAllAdmin()
    {
        return $this->model->whereHas('roles', function($query) {
            $query->where('name', config('constance.role.admin'));
        })->where('status', config('constance.const.user_active'))->get();
    }
}

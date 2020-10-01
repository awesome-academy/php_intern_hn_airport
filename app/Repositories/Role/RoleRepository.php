<?php
namespace App\Repositories\Role;

use App\Models\Request;
use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return Role::class;
    }

    public function findRoleByName($name)
    {
        return $this->model->where('name', $name)->select('id')->first();
    }
}

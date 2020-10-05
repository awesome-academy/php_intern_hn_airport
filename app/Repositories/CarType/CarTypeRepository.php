<?php
namespace App\Repositories\CarType;

use App\Models\CarType;
use App\Repositories\BaseRepository;
use App\Repositories\CarType\CarTypeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CarTypeRepository extends BaseRepository implements CarTypeRepositoryInterface
{
    public function getModel()
    {
        return CarType::class;
    }
}

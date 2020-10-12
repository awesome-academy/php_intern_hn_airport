<?php
namespace App\Repositories\ConfigBasic;

use App\Models\ConfigBasic;
use App\Repositories\BaseRepository;
use App\Repositories\ConfigBasic\ConfigBasicRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ConfigBasicRepository extends BaseRepository implements ConfigBasicRepositoryInterface
{
    public function getModel()
    {
        return ConfigBasic::class;
    }

    public function findCost($distance, $carType)
    {
        return $this->model->whereHas('configDistances', function($query) use ($distance) {
            $query->where('min', '<=', $distance)
                ->where('max', '>', $distance);
        })->whereHas('carTypes', function($query) use ($carType) {
            $query->where('type', $carType);
        })->select('cost')->first();
    }
}

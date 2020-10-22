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

    public function getAll()
    {
        return $this->model
            ->with([
                'configDistances',
                'carTypes',
            ])->orderBy('car_type_id')->get();
    }

    public function findAllCarTypes()
    {
        return $this->model->select('car_type_id')->distinct()->get();
    }

    public function findLowestCostCarType($carType)
    {
        return $this->model->where('car_type_id', $carType)->orderBy('cost', 'asc')->first();
    }

    public function deleteConfigByDistance($distance)
    {
        $result = $this->model->where('distance_id', $distance);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}

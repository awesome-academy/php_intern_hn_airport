<?php
namespace App\Repositories\ConfigDistance;

use App\Models\ConfigDistance;
use App\Repositories\BaseRepository;
use App\Repositories\ConfigDistance\ConfigDistanceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ConfigDistanceRepository extends BaseRepository implements ConfigDistanceRepositoryInterface
{
    public function getModel()
    {
        return ConfigDistance::class;
    }

    public function findConfig($distance)
    {
        return $this->model->where([
            ['min', '<', $distance],
            ['max', '>', $distance],
        ])->first();
    }

    public function findLastMaxConfig()
    {
        return $this->model->orderBy('max', 'desc')->limit(1)->first();
    }

    public function findRelatedDistanceByMax($max)
    {
        return $this->model->where('min', '=', $max)->first();
    }

    public function findRelatedDistanceByMin($min)
    {
        return $this->model->where('max', '=', $min)->first();
    }

    public function updateRelatedDistanceByMax($id, $max)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update(['min' => $max]);
            
            return $result;
        }

        return false;
    }

    public function updateRelatedDistanceByMin($id, $min)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update(['max' => $min]);
            
            return $result;
        }

        return false;
    }
}

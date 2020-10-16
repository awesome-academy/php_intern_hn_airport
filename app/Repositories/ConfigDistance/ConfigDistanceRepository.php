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
}

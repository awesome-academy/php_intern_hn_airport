<?php
namespace App\Repositories\Province;

use App\Models\Province;
use App\Repositories\BaseRepository;
use App\Repositories\Province\ProvinceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    public function getModel()
    {
        return Province::class;
    }

    public function getProvinceHasAiport()
    {
        return $this->model->has('provinceAirports')->get();
    }

    public function searchByName($cityName)
    {
        return $this->model->where('name', 'like', '%' . $cityName . '%')->first();
    }
}

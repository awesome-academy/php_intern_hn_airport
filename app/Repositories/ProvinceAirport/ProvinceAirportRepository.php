<?php
namespace App\Repositories\ProvinceAirport;

use App\Models\ProvinceAirport;
use App\Repositories\BaseRepository;
use App\Repositories\ProvinceAirport\ProvinceAirportRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProvinceAirportRepository extends BaseRepository implements ProvinceAirportRepositoryInterface
{
    public function getModel()
    {
        return ProvinceAirport::class;
    }

    public function find($id)
    {
        return $this->model->where('province_id', $id)->first();
    }
}

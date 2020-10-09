<?php
namespace App\Repositories\HostDetail;

use App\Models\HostDetail;
use App\Repositories\BaseRepository;
use App\Repositories\HostDetail\HostDetailRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class HostDetailRepository extends BaseRepository implements HostDetailRepositoryInterface
{
    public function getModel()
    {
        return HostDetail::class;
    }

    public function getAll()
    {
        return $this->model->where('user_id', Auth::id())
            ->with('provinces')
            ->with('carTypes')    
            ->get();
    }

    public function createHostDetail($attributes = [], $quantity)
    {
        return $this->model->firstOrCreate(
            $attributes,
            ['quantity' => $quantity]
        );
    }

    public function filterHostDetail($carTypeId, $provinceAirportId)
    {
        return $this->model->where('car_type_id', $carTypeId)
            ->whereHas('provinces', function($query) use ($provinceAirportId) {
                $query->whereHas('provinceAirports', function($query) use ($provinceAirportId){
                    $query->where('id', $provinceAirportId);
                });
            })->get();
    }
}

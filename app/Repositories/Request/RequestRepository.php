<?php
namespace App\Repositories\Request;

use App\Models\Request;
use App\Repositories\BaseRepository;
use App\Repositories\Request\RequestRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RequestRepository extends BaseRepository implements RequestRepositoryInterface
{
    public function getModel()
    {
        return Request::class;
    }

    public function getRequestNew()
    {
        return $this->model->where([
            'user_id'=> Auth::id(),
            'status' => config('constance.const.request_new')
        ])->with([
            'carTypes',
            'requestDestinations'
        ])->get();
    }

    public function getRequestCancel()
    {
        return $this->model->onlyTrashed()
            ->where('user_id', Auth::user()->id)
            ->with('carTypes')
            ->with('requestDestinations')
            ->get();
    }

    public function find($id)
    {
        return $this->model->withTrashed()->with(['carTypes', 
            'provinceAirports', 
            'requestDestinations',
            'provinceAirports.provinces'
        ])->findOrFail($id);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result && $result->status == config('constance.const.request_new')) {
            $result->update($attributes);
            
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result && $result->status == config('constance.const.request_new')) {
            $result->delete();
            $this->update($id, ['status' => config('constance.const.request_cancel')]);
            
            return true;
        }
    }

    public function getContractNewAgency()
    {
        return $this->model->whereHas('contract', function(Builder $query) {
            $query->where('status', config('constance.const.contract_new'));
        })->with([
            'contract',
            'carTypes',
            'requestDestinations',
        ])->where([
            'user_id' => Auth::id(),
            'status' => config('constance.const.request_to_contract'),
        ])->get();
    }

    public function getContractCancelAgency()
    {
        return $this->model->whereHas('contract', function(Builder $query) {
            $query->where('status', config('constance.const.contract_cancel'))->withTrashed();
        })->with([
            'carTypes',
            'requestDestinations',
            'contract' => function($query) {
                $query->where('status', config('constance.const.contract_cancel'))->withTrashed();
            },
        ])->where([
            'user_id' => Auth::id(),
            'status' => config('constance.const.request_to_contract'),
        ])->get();
    }
}

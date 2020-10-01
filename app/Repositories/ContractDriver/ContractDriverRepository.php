<?php
namespace App\Repositories\ContractDriver;

use App\Models\ContractDriver;
use App\Repositories\BaseRepository;
use App\Repositories\ContractDriver\ContractDriverRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ContractDriverRepository extends BaseRepository implements ContractDriverRepositoryInterface
{
    public function getModel()
    {
        return ContractDriver::class;
    }

    public function update($id, $attributes = [])
    {
        $result = $this->model->where('contract_id', $id);
        if ($result) {
            $result->update($attributes);
            
            return $result;
        }

        return false;
    }

    public function find($id)
    {
        $result = $this->model->where('contract_id', $id)->first();

        return $result;
    }
}

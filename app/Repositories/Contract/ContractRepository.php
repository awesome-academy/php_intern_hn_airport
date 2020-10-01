<?php
namespace App\Repositories\Contract;

use App\Models\Contract;
use App\Repositories\BaseRepository;
use App\Repositories\Contract\ContractRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ContractRepository extends BaseRepository implements ContractRepositoryInterface
{
    public function getModel()
    {
        return Contract::class;
    }

    public function getContractNewHost()
    {
        return $this->model->where([
            'supplier_id' => Auth::id(),
            'status' => config('constance.const.request_new')
        ])->with([
            'request.carTypes',
            'request.requestDestinations',
        ])->get();
    }

    public function getContractCancelHost()
    {
        return $this->model->onlyTrashed()->where('supplier_id', Auth::id())->with([
            'request.carTypes',
            'request.requestDestinations'
        ])->get();
    }

    public function find($id)
    {
        return $this->model->withTrashed()->with([
            'request.requestDestinations',
            'request.requestCustomer',
            'contractDriver',
        ])->findOrFail($id);
    }

    public function delete($id)
    {
        $result =  $this->model->find($id);
        if ($result) {
            if ($result->status != config('constance.const.contract_new')) {
                return response()->json(trans('contents.common.alert.message.delete_contract_fail'), 500);
            }
            $result->update(['status' => config('constance.const.contract_cancel')]);
            $result->delete();

            return true;
        }

        return false;
    }
}

<?php
namespace App\Repositories\RequestDestination;

use App\Models\RequestDestination as ModelsRequestDestination;
use App\Repositories\BaseRepository;
use App\Repositories\RequestDestination\RequestDestinationRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RequestDestinationRepository extends BaseRepository implements RequestDestinationRepositoryInterface
{
    public function getModel()
    {
        return ModelsRequestDestination::class;
    }

    public function delete($id)
    {
        $result = $this->model->where('request_id', $id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}

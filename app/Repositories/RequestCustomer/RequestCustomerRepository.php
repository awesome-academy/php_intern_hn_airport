<?php
namespace App\Repositories\RequestCustomer;

use App\Models\RequestCustomer;
use App\Repositories\BaseRepository;
use App\Repositories\RequestCustomer\RequestCustomerRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RequestCustomerRepository extends BaseRepository implements RequestCustomerRepositoryInterface
{
    public function getModel()
    {
        return RequestCustomer::class;
    }
}

<?php
namespace App\Repositories\HostDetail;

interface HostDetailRepositoryInterface
{
    public function createHostDetail($attributes = [], $quantity);
}

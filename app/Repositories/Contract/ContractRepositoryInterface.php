<?php
namespace App\Repositories\Contract;

interface ContractRepositoryInterface
{
    public function getContractNewHost();

    public function getContractCancelHost();

    public function countContractByDate($date);
}

<?php
namespace App\Repositories\Request;

interface RequestRepositoryInterface
{
    public function getRequestNew();

    public function getRequestCancel();

    public function getContractNewAgency();

    public function getContractCancelAgency();

    public function getRequestNewHost();
}

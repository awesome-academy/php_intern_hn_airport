<?php
namespace App\Repositories\Request;

interface RequestRepositoryInterface
{
    public function getRequestNew();

    public function getRequestCancel();

    public function getContractNewAgency();

    public function getContractCancelAgency();

    public function getRequestNewHost();

    public function countRequestByDate($date);

    public function countUniqueRequestByDate($date);

    public function getRequestByMonth($month);

    public function getCancelRequestByMonth($month);

    public function countRequestByMonth($month);

    public function countCancelRequestByMonth($month);
}

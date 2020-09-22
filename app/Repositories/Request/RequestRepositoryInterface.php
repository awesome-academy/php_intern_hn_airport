<?php
namespace App\Repositories\Request;

interface RequestRepositoryInterface
{
    public function getRequestNew();

    public function getRequestCancel();
}

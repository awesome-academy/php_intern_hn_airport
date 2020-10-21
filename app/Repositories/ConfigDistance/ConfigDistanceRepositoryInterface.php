<?php
namespace App\Repositories\ConfigDistance;

interface ConfigDistanceRepositoryInterface
{
    public function findConfig($distance);

    public function findLastMaxConfig();

    public function findRelatedDistanceByMin($min);

    public function findRelatedDistanceByMax($max);

    public function updateRelatedDistanceByMin($id, $min);

    public function updateRelatedDistanceByMax($id, $max);
}

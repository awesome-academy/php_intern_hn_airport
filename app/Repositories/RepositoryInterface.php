<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();
    
    public function find($id);

    public function create($attribues = []);

    public function update($id, $attribues = []);
}

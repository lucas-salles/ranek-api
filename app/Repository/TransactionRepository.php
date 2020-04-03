<?php

namespace App\Repository;

class TransactionRepository extends AbstractRepository
{
    public function getUserTransactions($type, $user)
    {
        $this->model = $this->model->where("{$type}", "=", "{$user}");
        
        return $this->model;
    }
}
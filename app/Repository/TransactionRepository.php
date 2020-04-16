<?php

namespace App\Repository;

class TransactionRepository extends AbstractRepository
{
    public function getUserTransactions($type, $user)
    {
        $this->model = $this->model->where("{$type}_id", "=", "{$user}");
        
        return $this->model;
    }
}
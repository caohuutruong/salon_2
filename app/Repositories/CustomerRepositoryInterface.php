<?php

namespace App\Repositories;

interface CustomerRepositoryInterface
{
    public function upsertCustomer(array $data);
    public function deleteCustomer(int $id);
    public function getCustomerById(int $id);
    public function getCustomers(int $page, int $size);
    public function countCustomers(): int;

}
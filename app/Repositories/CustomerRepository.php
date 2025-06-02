<?php
namespace App\Repositories;

use App\DAO\CustomerDAO;
use Illuminate\Support\Facades\DB;
class CustomerRepository implements CustomerRepositoryInterface
{
    private $customerDAO;

    public function __construct(CustomerDAO $customerDAO)
    {
        $this->customerDAO = $customerDAO;
    }
    public function countCustomers(): int
    {
        return $this->customerDAO->countCustomers();

    }

    public function upsertCustomer(array $data)
    {
        return $this->customerDAO->upsertCustomer($data);
    }

    public function deleteCustomer(int $id)
    {
        return $this->customerDAO->deleteCustomer($id);
    }

    public function getCustomerById(int $id)
    {
        return $this->customerDAO->getCustomerById($id);
    }

    public function getCustomers(int $page, int $size)
    {
        return $this->customerDAO->getCustomers($page, $size + 1);
    }
    
}
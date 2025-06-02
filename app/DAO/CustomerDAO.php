<?php

namespace App\DAO;

use Illuminate\Support\Facades\DB;

class CustomerDAO
{
    public function upsertCustomer(array $data)
    {
        try {
            return DB::statement('EXEC SPC_CUSTOMER_ACT1 ?, ?, ?, ?, ?, ?', [
                $data['id'] ?? null,
                $data['name'],
                $data['email'], 
                $data['phone'] ?? null,
                $data['price'] ?? 0,
                json_encode($data['services_used'] ?? [])
            ]);
        } catch (\Exception $e) {
            // Re-throw để controller có thể catch và xử lý
            throw $e;
        }
    }

    public function deleteCustomer(int $id)
    {
        return DB::statement('EXEC SPC_CUSTOMER_ACT2 ?', [$id]);
    }

    public function getCustomerById(int $id)
    {
        $result = DB::select('SELECT * FROM customers WHERE id = ?', [$id]);
        
        if (empty($result)) {
            return null;
        }
        
        $customer = $result[0];
        
        // Parse JSON services_used về array
        if ($customer->services_used) {
            $customer->services_used = json_decode($customer->services_used, true);
        }
        
        return $customer;
    }

    public function getCustomers(int $page, int $size)
    {
        return DB::select('EXEC SPC_CUSTOMER_LS1 ?, ?', [$page, $size]);
    }
    public function countCustomers(): int
    {
        return DB::table('customers')->count();
    }

}
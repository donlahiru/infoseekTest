<?php namespace App\Interfaces;

interface CustomerInterface
{
    public function getAllCustomers();
    
    public function getCustomerById($id);

    public function saveCustomer($input);

    public function updateCustomer($input);
    
    public function deleteCustomer($id);
}
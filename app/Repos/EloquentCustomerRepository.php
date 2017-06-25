<?php namespace App\Repos;

use App\Interfaces\CustomerInterface;
use App\Models\Customers;

class EloquentCustomerRepository implements CustomerInterface
{
    protected $customer;
    
    public function __construct(Customers $customer)
    {
        $this->customer = $customer;
    }

    public function getAllCustomers()
    {
        try
        {
            $customer = $this->customer->all()->toArray();
            return $customer;
        }
        catch (Exception $e) 
        {
            Log::error('Error occcured getting all customers.', ['exception' => $e]);
        }
    }

    public function getCustomerById($id)
    {
        try
        {
            $customer = $this->customer->find($id);
            return $customer;
        }
        catch (Exception $e)
        {
            Log::error('Error occcured getting a customers.', ['exception' => $e]);
        }
    }
    
    public function saveCustomer($input)
    {
        $customer = $this->customer;

        $customer->firstName    = $input['firstName'];
        $customer->lastName     = $input['lastName'];
        $customer->email        = $input['email'];
        $customer->address      = $input['address'];
        $customer->contactNo    = $input['contactNo'];

        $saved  = $customer->save();

        return $saved;
    }

    public function updateCustomer($input)
    {
        $customer   = $this->customer->findOrFail($input['id']);
        $customer->fill($input);

        $update     = $customer->save();

        return $update ? $customer : false;
    }

    public function deleteCustomer($id)
    {
        $customer = $this->customer->findOrFail($id);
        return $customer->delete();
    }
}
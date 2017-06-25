<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CustomerInterface;
use Dingo\Api\Http\Response;
use Exception;
use Validator;

class ApiCustomersController extends Controller
{
    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @param CustomerInterface $customer
     */
    function __construct(CustomerInterface $customer)
    {
        $this->customer    = $customer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers     = $this->customer->getAllCustomers();
        
        return response()->json($customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store()
    {
        try
        {
            DB::beginTransaction();

            $input = Input::all();

            $rules = [
                'firstName' => 'required|max:255',
                'lastName' => 'required|max:255',
                'email' => 'required|email|max:255|unique:CUSTOMER,email',
                'address' => 'max:255',
                'contactNo' => 'regex:/^([0-9\(\)\+]*)$/|required|max:10',
            ];

            $messages = [
                'contactNo.required' => 'Please key in a valid contact number.',
                'contactNo.regex'    => 'Invalid contact number format.',
                'email.unique'    => 'The email you entered exists. Please enter another email.',
            ];

            $validator = Validator::make($input, $rules, $messages);

            if ($validator->passes())
            {
                $result     = $this->customer->saveCustomer($input);

                if(!$result)
                    throw new Exception('Customer saving error.');

                DB::commit();
                return Response()->json(array(
                    'error'   => false,
                    'message' => "Customer saved successfully.",
                    'data'    => $result,
                ));
            }

            DB::rollBack();
            return Response()->json(array(
                'error'   => true,
                'message' => "Customer was not created, please try again.",
                'data'    => $validator->messages(),
            ));
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $validator->errors()->add('validation', $e->getMessage());

            return Response()->json(array(
                'error'   => true,
                'message' => "Customer was not created, please try again.",
                'data'    => $validator->messages(),
            ));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customers     = $this->customer->getCustomerById($id);

        return response()->json($customers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try
        {
            DB::beginTransaction();

            $input = Input::all();

            $rules = [
                'firstName' => 'sometimes|required|max:255',
                'lastName' => 'sometimes|required|max:255',
                'email' => "sometimes|required|email|max:255|unique:CUSTOMER,email,{$id}",
                'address' => 'sometimes|max:255',
                'contactNo' => 'sometimes|regex:/^([0-9\(\)\+]*)$/|required|max:10',
            ];

            $messages = [
                'contactNo.required' => 'Please key in a valid contact number.',
                'contactNo.regex'    => 'Invalid contact number format.',
                'email.unique'    => 'The email you entered exists. Please enter another email.',
            ];

            $validator = Validator::make($input, $rules, $messages);

            if ($validator->passes())
            {
                $input['id']    = $id;
                $result         = $this->customer->updateCustomer($input);

                if(!$result)
                    throw new Exception('Customer updating error.');

                DB::commit();
                return Response()->json(array(
                    'error'   => false,
                    'message' => "Customer updated successfully.",
                    'data'    => $result,
                ));
            }

            DB::rollBack();
            return Response()->json(array(
                'error'   => true,
                'message' => "Customer was not updated, please try again.",
                'data'    => $validator->messages(),
            ));
        }
        catch(Exception $e)
        {
            DB::rollBack();
            $validator->errors()->add('validation', $e->getMessage());

            return Response()->json(array(
                'error'   => true,
                'message' => "Customer was not updated, please try again.",
                'data'    => $validator->messages(),
            ));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            DB::beginTransaction();
            
            $result         = $this->customer->deleteCustomer($id);

            if(!$result)
                throw new Exception('Customer deleting error.');

            DB::commit();
            return Response()->json(array(
                'error'   => false,
                'message' => "Customer deleted successfully.",
                'data'    => $result,
            ));
           

            DB::rollBack();
            return Response()->json(array(
                'error'   => true,
                'message' => "Customer was not deleted, please try again.",
                'data'    => $result,
            ));
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return Response()->json(array(
                'error'   => true,
                'message' => "Customer was not deleted, please try again.",
                'data'    => $e->getMessage(),
            ));
        }
    }
}

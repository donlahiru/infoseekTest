<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table      = 'CUSTOMER';
    protected $softDelete = true;
    protected $fillable   = array(
        'id',
        'firstName',
        'lastName',
        'email',
        'contactNo',
    );
}

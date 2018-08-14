<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

abstract class Person
{

    var $name;
    var $address;
    var $email;
    var $telephone;


    public function __construct(Request $request)
    {
        $this->name = $request->input('name');
        $this->address = $request->input('address');
        $this->email = $request->input('email');
        $this->telephone = $request->input('telephone');

    }


}




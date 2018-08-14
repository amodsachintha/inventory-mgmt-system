<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

class Customer extends Person
{
    var $id;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->id = $request->input('id');
    }


}




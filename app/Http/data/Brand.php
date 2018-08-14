<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

class Brand
{
    var $id;
    var $name;
    var $brandcode;
    var $brandlogo;


    public function __construct(Request $request)
    {
        $this->id = $request->input('id');
        $this->name = $request->input('name');
        $this->brandcode = $request->input('brandcode');
        $this->brandlogo = $request->input('brandlogo');
    }


}




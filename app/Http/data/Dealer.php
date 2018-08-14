<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

class Dealer extends Person
{
    var $id;
    var $type;



    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->id = $request->input('id');
        $this->type = $request->input('type');

    }


}




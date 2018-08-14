<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

class Cart
{
    var $id;
    var $itemcode;
    var $quantity;
    var $fromdealer;


    public function __construct(Request $request)
    {
        $this->itemcode = $request->input('itemcode');
        $this->id = $request->input('id');
        $this->quantity= $request->input('quantity');
        $this->fromdealer = $request->input('fromdealer');
    }


}




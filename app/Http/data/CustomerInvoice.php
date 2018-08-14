<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

 class CustomerInvoice extends Invoice
{
    var $id;
    var $amount;
    var $discount;


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->id = $request->input('id');
        $this->amount = $request->input('amount');
        $this->discount = $request->input('discount');
    }


}




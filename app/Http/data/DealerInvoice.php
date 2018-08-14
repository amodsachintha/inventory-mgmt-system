<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

 class DealerInvoice extends Invoice
{
    var $id;


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->id = $request->input('id');
    }


}




<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

abstract class Invoice
{
    var $invoicecode;
    var $type;
    var $fullamount;
    var $date;
    var $invoiceDetail;

    public function __construct(Request $request)
    {
        $this->invoicecode = $request->input('invoicecode');
        $this->type = $request->input('type');
        $this->fullamount = $request->input('fullamount');
        $this->date = $request->input('date');
    }


}




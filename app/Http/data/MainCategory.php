<?php
namespace App\Http\Data;
use Illuminate\Http\Request;

class MainCategory extends Category {



    public function __construct(Request $request)
    {
        parent::__construct($request);
    }


}
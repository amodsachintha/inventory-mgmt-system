<?php
namespace App\Http\Data;
use Illuminate\Http\Request;

class SubCategory extends Category {

    var $mainCategory;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->mainCategory=new MainCategory($request);
    }

}
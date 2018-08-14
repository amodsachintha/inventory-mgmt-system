<?php
namespace App\Http\Data;
use Illuminate\Http\Request;

abstract class Category{

    var $id;
    var $name;


    public function __construct(Request $request)
    {
        $this->id=$request->input('id');
        $this->name=$request->input('name');
    }


}
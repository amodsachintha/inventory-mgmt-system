<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

class Item
{
    var $itemcode;
    var $name;
    var $subheading;
    var $description;
    var $brandcode;
    var $category;
    var $subcategory;
    var $price;
    var $discount;
    var $warranty;
    var $enabled;
    var $date;

    public function __construct(Request $request)
    {
        $this->itemcode = $request->input('itemcode');
        $this->name = $request->input('name');
        $this->subheading = $request->input('subheading');
        $this->description = $request->input('description');
        $this->brandcode = $request->input('brandcode');
        $this->category = $request->input('category');
        $this->subcategory = $request->input('subcategory');
        $this->price = $request->input('price');
        $this->discount = $request->input('discount');
        $this->warranty = $request->input('warranty');
        $this->enabled = $request->input('enabled');
        $this->date = $request->input('date');
    }


}




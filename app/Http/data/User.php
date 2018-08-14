<?php

namespace App\Http\Data;
use Illuminate\Http\Request;

class User
{
    var $id;
    var $name;
    var $fullname;
    var $email;
    var $avatar;

    public function __construct(Request $request)
    {
        $this->id = $request->input('id');
        $this->name = $request->input('name');
        $this->fullname = $request->input('fullname');
        $this->email = $request->input('email');
        $this->avatar = $request->input('avatar');

    }


}




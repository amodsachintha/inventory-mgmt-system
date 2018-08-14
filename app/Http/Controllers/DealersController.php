<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DealersController extends Controller
{
    public function show(Request $request)
    {
        if (Auth::check()) {
            try {
                if (isset($request->search)) {
                    $dealersTable = DB::table('dealers')
                        ->where('name','like','%'.$request->search.'%')
                        ->orWhere('email','like','%'.$request->search.'%')
                        ->get();
                    return view('pages.dealers')
                        ->with('searchtext', $request->search)
                        ->with('dealersTable', $dealersTable);
                } else {
                    $dealersTable = DB::table('dealers')
                        ->get();
                    return view('pages.dealers')
                        ->with('dealersTable', $dealersTable);
                }
            } catch (QueryException $e) {
                return $e->getMessage();
            }

        } else {
            return "Error 403 : Forbidden";
        }
    }


    public function addNew(Request $request)
    {
        if (Auth::check()) {
//            return var_dump($request->input());
            try {
                DB::table('dealers')
                    ->insert([
                        'name' => $request->input('name'),
                        'type' => $request->input('type'),
                        'address' => $request->input('address'),
                        'email' => $request->input('email'),
                        'telephone' => $request->input('telephone'),
                    ]);

                return redirect('/pages/dealers');
            } catch (QueryException $e) {
                return $e->getMessage();
            }

        } else {
            return "Error 403 : Forbidden";
        }
    }


}

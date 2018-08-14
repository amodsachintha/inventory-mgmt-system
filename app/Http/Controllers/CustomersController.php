<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    public function show(Request $request)
    {
        if (Auth::check()) {

            if (isset($request->search)) {
                try {
                    $customersTable = DB::table('customers')
                        ->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->get();
                    return view('pages.customers')
                        ->with('customersTable', $customersTable)
                        ->with('searchtext',$request->search)
                        ->with('invCode', $this->generateInvoiceCode('CUST'));
                } catch (QueryException $e) {
                    return $e->getMessage();
                }
            } else {
                try {
                    $customersTable = DB::table('customers')
                        ->get();
                    return view('pages.customers')
                        ->with('customersTable', $customersTable)
                        ->with('invCode', $this->generateInvoiceCode('CUST'));
                } catch (QueryException $e) {
                    return $e->getMessage();
                }
            }

        } else {
            return "Error 403 : Forbidden";
        }
    }

    private function generateInvoiceCode($type)
    {
        if ($type == "CUST") {
            return "INV_" . "CUST_" . str_random(12);
        } else {
            return "INV_" . "DEAL_" . str_random(12);
        }
    }


    public function addNew(Request $request)
    {
        if (Auth::check()) {
            try {
                DB::table('customers')
                    ->insert([
                        'name' => $request->input('name'),
                        'address' => $request->input('address'),
                        'email' => $request->input('email'),
                        'telephone' => $request->input('telephone'),
                    ]);

                return redirect('/pages/customers');
            } catch (QueryException $e) {
                return $e->getMessage();
            }

        } else {
            return "Error 403 : Forbidden";
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public static function getCartItemCount1()
    {
        try {
            return DB::table('maincart')
                ->where('fromdealer', '=', 'N')
                ->count();
        } catch (QueryException $e) {
            return "ERR";
        }
    }

    public static function getCartItemCount2()
    {
        try {
            return DB::table('maincart')
                ->where('fromdealer', '=', 'Y')
                ->count();
        } catch (QueryException $e) {
            return "ERR";
        }
    }


    public function show()
    {
        if (Auth::check()) {
            try {
                $cartTable = DB::table('maincart')
                    ->where('fromdealer','N')
                    ->join('items', 'maincart.itemcode', '=', 'items.itemcode')
                    ->select('items.*', 'maincart.*')
                    ->get();

                return view('pages.cart')
                    ->with('cartTable', $cartTable)
                    ->with('invCode',$this->generateInvoiceCode("CUST"))
                    ->with('fromDealer','N');
            } catch (QueryException $e) {
                return "SERVER ERROR!";
            }

        } else
            return "ERROR 403: Permission Denied!";
    }


    public function showFromDealer()
    {
        if (Auth::check()) {
            try {
                $cartTable = DB::table('maincart')
                    ->where('fromdealer','Y')
                    ->join('items', 'maincart.itemcode', '=', 'items.itemcode')
                    ->select('items.*', 'maincart.*')
                    ->get();

                return view('pages.cart')
                    ->with('cartTable', $cartTable)
                    ->with('invCode',$this->generateInvoiceCode("DEAL"))
                    ->with('fromDealer','Y');;
            } catch (QueryException $e) {
                return "SERVER ERROR!";
            }

        } else
            return "ERROR 403: Permission Denied!";
    }

    private function generateInvoiceCode($type)
    {
        if ($type == "CUST") {
            return "INV_" . "CUST_" . str_random(12);
        } else {
            return "INV_" . "DEAL_" . str_random(12);
        }
    }

    public function addToCart(Request $request)
    {
        if (Auth::check()) {
            try {

                $stock = DB::table('stock')
                    ->where('itemcode', $request->itemcode)
                    ->first();

                $item = DB::table('items')
                    ->where('itemcode', $request->itemcode)
                    ->first();

                $result = DB::table('maincart')
                    ->where('fromdealer','=','N')
                    ->where('itemcode', '=', $request->itemcode)
                    ->first();

                if ($stock->amount >= 1 && $item->enabled == "YES") {

                    if (isset($result) && $result->quantity < $stock->amount) {
                        $qua = $result->quantity + 1;
                        DB::table('maincart')
                            ->where('fromdealer','=','N')
                            ->where('itemcode', $request->itemcode)
                            ->update([
                                'quantity' => $qua
                            ]);
                    } elseif (isset($result) && $result->quantity >= $stock->amount) {
                        $rtr = $request->server->get('HTTP_REFERER');
                        return "<script>alert('Stock level reached! Adding failed!'); window.location.href='$rtr';</script>";
                    } else {
                        DB::table('maincart')
                            ->insert([
                                'itemcode' => $request->itemcode,
                                'quantity' => 1,
                            ]);
                    }
                }
                return redirect($request->server->get('HTTP_REFERER'));
            } catch (QueryException $e) {
                return $e->getMessage();
            }
        } else {
            return "ERROR 403 : Permission Denied";
        }
    }

    public function addAllToCart(Request $request)
    {
        if (Auth::check()) {
            try {

                $currentCart = DB::table('maincart')
                                ->where('itemcode',$request->input('itemcode'))
                                ->where('fromdealer','Y')
                                ->first();

                if(!isset($currentCart)){
                    $stock = DB::table('stock')
                        ->where('itemcode', $request->itemcode)
                        ->first();

                    DB::table('maincart')
                        ->insert([
                            'itemcode' => $request->input('itemcode'),
                            'quantity' => $stock->amount,
                            'fromdealer' => 'Y'
                        ]);
                }

                return redirect($request->server->get('HTTP_REFERER'));
            } catch (QueryException $e) {
                return "Server Error!";
            }
        } else
            return "ERROR 403 : Permission Denied";
    }


    public function removeFromCart(Request $request)
    {
        if (Auth::check()) {
            try {
                DB::table('maincart')
                    ->where('itemcode', $request->itemcode)
                    ->delete();
                return redirect($request->server->get('HTTP_REFERER'));
            } catch (QueryException $e) {
                return "SERVER ERROR!";
            }
        } else {
            return "ERROR 403 : Permission Denied";
        }
    }

    public function minus(Request $request)
    {
        if (Auth::check()) {
            try {
                $cartItem = DB::table('maincart')
                    ->where('fromdealer','=','N')
                    ->where('itemcode', $request->itemcode)
                    ->first();
                if (isset($cartItem)) {
                    if ($cartItem->quantity == 1) {
                        DB::table('maincart')
                            ->where('fromdealer','=','N')
                            ->where('itemcode', $request->itemcode)
                            ->delete();
                    } elseif ($cartItem->quantity > 0) {
                        DB::table('maincart')
                            ->where('fromdealer','=','N')
                            ->where('itemcode', $request->itemcode)
                            ->update([
                                'quantity' => $cartItem->quantity - 1,
                            ]);
                    } else {
                        return back();
                    }
                }
                return redirect($request->server->get('HTTP_REFERER'));
            } catch (QueryException $e) {
                return "SERVER ERROR";
            }
        } else
            return "ERROR 403 : Permission Denied";
    }

}
























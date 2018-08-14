<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Yaml\Tests\A;

class InvoiceController extends Controller
{

    public function showSalesInvoices(Request $request)
    {

        if (Auth::check()) {
            if (isset($request->orderby)) {
                try {
                    $invoices = DB::table('invoice')
                        ->where('type', 'CUST')
                        ->orderBy($request->input('orderby'), 'ASC')
                        ->paginate(15);
                } catch (QueryException $exception) {
                    return "Server Error!";
                }
            } elseif (isset($request->custid)) {
                try {
                    $invoices = DB::table('invoice')
                        ->where('type', 'CUST')
                        ->where('customerid', $request->custid)
                        ->paginate(15);
                } catch (QueryException $exception) {
                    return "Server Error!";
                }
            } else {
                try {
                    $invoices = DB::table('invoice')
                        ->where('type', 'CUST')
                        ->orderBy('date', 'DESC')
                        ->paginate(15);
                } catch (QueryException $exception) {
                    return "Server Error!";
                }
            }

            return view('pages.invoice')
                ->with('fromDealer', 'N')
                ->with('invoiceTable', $invoices);


        } else
            return "Error 403: Permission Denied";
    }


    public function showDealerInvoices(Request $request)
    {
        if (Auth::check()) {
            try {
                if (isset($request->orderby)) {
                    $invoices = DB::table('dealerinvoice')
                        ->where('type', 'DEAL')
                        ->orderBy($request->input('orderby'))
                        ->paginate(15);
                } elseif (isset($request->dealerid)) {
                    $invoices = DB::table('dealerinvoice')
                        ->where('type', 'DEAL')
                        ->where('dealerid', $request->input('dealerid'))
                        ->orderBy('date')
                        ->paginate(15);
                } else {
                    $invoices = DB::table('dealerinvoice')
                        ->where('type', 'DEAL')
                        ->orderBy('date')
                        ->paginate(15);

                }

                return view('pages.invoice')
                    ->with('invoiceTable', $invoices)
                    ->with('fromDealer', 'Y');
            } catch (QueryException $exception) {
                return "Server Error!";
            }

        } else
            return "Error 403: Permission Denied";
    }

    public function showSelectCustomer(Request $request)
    {
        if (Auth::check()) {
            try {
                $cust = DB::table('customers')
                    ->get();
                return view('innerpages.selectcustomer')
                    ->with('customerTable', $cust)
                    ->with('invCode', $request->invCode);

            } catch (QueryException $e) {
                return "ERROR";
            }

        }
        return "403";

    }

    public function showSelectDealer(Request $request)
    {
        if (Auth::check()) {
            try {
                $deal = DB::table('dealers')
                    ->get();
                return view('innerpages.selectdealer')
                    ->with('dealerTable', $deal)
                    ->with('invCode', $request->invCode);

            } catch (QueryException $e) {
                return "ERROR";
            }

        }
        return "403";
    }


    public function generateSalesInvoice(Request $request)
    {
        $loc = $request->server->get('HTTP_REFERER');
        if (Auth::check()) {
            if (str_contains($request->input('invCode'), ":")) {
                $invCode = explode(":", $request->input('invCode'))[0];
                $custID = explode(":", $request->input('invCode'))[1];
                $redirect = true;
            } else {
                $invCode = $request->input('invCode');
                $custID = $request->input('custid');
                $redirect = false;
            }
            try {

                $count = DB::table('maincart')
                    ->where('fromdealer', 'N')
                    ->count();

                if ($count <= 0) {
                    return "<script>alert('Cart Empty!'); window.location.href='$loc';</script>";
                }

                $cart = DB::table('maincart')
                    ->where('fromdealer', 'N')
                    ->join('items', 'items.itemcode', 'maincart.itemcode')
                    ->select('maincart.*', 'items.price', 'items.discount')
                    ->get();

                $subtotal = 0.0;
                $fulltotal = 0.0;

                foreach ($cart as $cartItem) {
                    $discountedprice = ($cartItem->price * ((100 - $cartItem->discount) / 100.0)) * $cartItem->quantity;
                    $price = $cartItem->price * $cartItem->quantity;

                    $fulltotal = $fulltotal + $price;
                    $subtotal = $subtotal + $discountedprice;
                }

                $discount = $fulltotal - $subtotal;

                DB::table('invoice')
                    ->insert([
                        'invoicecode' => $invCode,
                        'customerid' => $custID,
                        'type' => 'CUST',
                        'fullamount' => $fulltotal,
                        'amount' => $subtotal,
                        'discount' => $discount
                    ]);

                foreach ($cart as $cartItem) {

                    $tmp_discount = ($cartItem->price * $cartItem->discount / 100.0) * $cartItem->quantity;

                    DB::table('invoice_detail')
                        ->insert([
                            'invoicecode' => $invCode,
                            'itemcode' => $cartItem->itemcode,
                            'quantity' => $cartItem->quantity,
                            'unitprice' => $cartItem->price,
                            'discount' => $tmp_discount,
                            'subtotal' => ($cartItem->price * $cartItem->quantity) - $tmp_discount
                        ]);

                    $stock = DB::table('stock')
                        ->where('itemcode', $cartItem->itemcode)
                        ->first();

                    DB::table('stock')
                        ->where('itemcode', $cartItem->itemcode)
                        ->update([
                            'amount' => $stock->amount - $cartItem->quantity
                        ]);

                }

                DB::table('maincart')
                    ->where('fromdealer', 'N')
                    ->delete();
            } catch (QueryException $e) {
                return "SERVER ERROR";
            }
            $location = "http://admin.dreamtech.lk/invoice/showsalesinvoice?invoicecode=".$invCode;
            if ($redirect) {
//                $location = $request->server->get('HTTP_REFERER');

                return "<script>alert('Invoice generated Successfully'); window.location.href='$location';</script>";
            } else {
                return "<script>alert('Invoice generated Successfully'); window.location.href='$location';</script>";
            }


        } else {
            return "Error 403: Permission Denied";
        }

    }

    public function generateDealerInvoice(Request $request)
    {
        if (Auth::check()) {
            if (str_contains($request->input('invCode'), ":")) {
                $invCode = explode(":", $request->input('invCode'))[0];
                $dealerID = explode(":", $request->input('invCode'))[1];
                $redirect = true;
            } else {
                $invCode = $request->input('invCode');
                $dealerID = $request->input('dealerid');
                $redirect = false;
            }
            try {

                $cart = DB::table('maincart')
                    ->where('fromdealer', 'Y')
                    ->join('items', 'items.itemcode', 'maincart.itemcode')
                    ->select('maincart.*', 'items.price', 'items.discount')
                    ->get();

                $subtotal = 0.0;
                $fulltotal = 0.0;

                foreach ($cart as $cartItem) {
                    $price = $cartItem->price * $cartItem->quantity;
                    $fulltotal = $fulltotal + $price;
                }


                DB::table('dealerinvoice')
                    ->insert([
                        'invoicecode' => $invCode,
                        'dealerid' => $dealerID,
                        'type' => 'DEAL',
                        'fullamount' => $fulltotal,
                    ]);

                foreach ($cart as $cartItem) {

                    DB::table('invoice_detail_dealer')
                        ->insert([
                            'invoicecode' => $invCode,
                            'itemcode' => $cartItem->itemcode,
                            'quantity' => $cartItem->quantity,
                            'unitprice' => $cartItem->price,
                            'subtotal' => $cartItem->price * $cartItem->quantity,
                        ]);

                    $stock = DB::table('stock')
                        ->where('itemcode', $cartItem->itemcode)
                        ->first();

                    DB::table('stock')
                        ->where('itemcode', $cartItem->itemcode)
                        ->update([
                            'instock' => 'YES',
                            'amount' => $stock->amount + $cartItem->quantity
                        ]);

                    DB::table('items')
                        ->where('itemcode', $cartItem->itemcode)
                        ->update([
                            'enabled' => 'YES',
                        ]);

                }

                DB::table('maincart')
                    ->where('fromdealer', 'Y')
                    ->delete();
            } catch (QueryException $e) {
                return $e->getMessage();
            }

            if ($redirect) {
                $location = "/invoice/showdealernvoice?invoicecode=" . $invCode;
                return "<script>alert('Invoice generated Successfully'); window.location.href='$location';</script>";
            } else {
                return "<script>alert('Invoice generated Successfully'); window.close();</script>";
            }


        } else {
            return "Error 403: Permission Denied";
        }
    }


    public function showSalesInvoiceDetail(Request $request)
    {
        if (Auth::check()) {
            try {
                $invoiceRow = DB::table('invoice')
                    ->where('invoicecode', $request->input('invoicecode'))
                    ->join('customers', 'invoice.customerid', 'customers.idcustomers')
                    ->select('customers.name', 'invoice.*')
                    ->first();

                if(!isset($invoiceRow))
                {
                    $loc = "/pages/invoice/sales";
                    return "<script>alert('Invalid Invoice Code!'); window.location.href='$loc';</script>";
                }
                $invoiceDetailTable = DB::table('invoice_detail')
                    ->where('invoicecode', $request->input('invoicecode'))
                    ->get();
                return view('innerpages.salesinvoice')
                    ->with('invoicecode', $request->input('invoicecode'))
                    ->with('invoicedetailtable', $invoiceDetailTable)
                    ->with('invoicerow', $invoiceRow);

            } catch (QueryException $e) {
                return "INVALID QUERY :_(";
            }
        } else {
            return "Error 403: Permission Denied";
        }
    }

    public function showDealerInvoiceDetail(Request $request)
    {
        if (Auth::check()) {
            try {
                $invoiceRow = DB::table('dealerinvoice')
                    ->where('invoicecode', $request->input('invoicecode'))
                    ->join('dealers', 'dealerinvoice.dealerid', 'dealers.iddealers')
                    ->select('dealers.name', 'dealerinvoice.*')
                    ->first();

                if(!isset($invoiceRow))
                {
                    $loc = "/pages/invoice/dealer";
                    return "<script>alert('Invalid Invoice Code!'); window.location.href='$loc';</script>";
                }

                $invoiceDetailTable = DB::table('invoice_detail_dealer')
                    ->where('invoicecode', $request->input('invoicecode'))
                    ->get();
                return view('innerpages.dealerinvoice')
                    ->with('invoicecode', $request->input('invoicecode'))
                    ->with('invoicedetailtable', $invoiceDetailTable)
                    ->with('invoicerow', $invoiceRow);

            } catch (QueryException $e) {
//                return $e->getMessage();
                return "INVALID QUERY :_(";
            }
        } else {
            return "Error 403: Permission Denied";
        }
    }

    public function filterDateSales(Request $request){
        $from = date_create($request->from);
        $to = date_create($request->to);
        $loc = $request->server->get('HTTP_REFERER');

        if(date_diff($from,$to)->invert == 1){
           return "<script>alert('Inverted Selection! Invalid!'); window.location.href='$loc'</script>";
        }

        if(Auth::check()){
            $invoiceTable = DB::table('invoice')
                            ->where('type', 'CUST')
                            ->whereDate('date','>=',$request->from)
                            ->whereDate('date','<=',$request->to)
                            ->orderBy('date','DESC')
                            ->paginate(15);

            return view('pages.invoice')
                ->with('fromDealer', 'N')
                ->with('dates',['from'=>$request->from,'to'=>$request->to])
                ->with('invoiceTable', $invoiceTable);
        }
        else{
            return "ERROR! : PERMISSION DENIED";
        }
    }

    public function filterDateDealer(Request $request){
        $from = date_create($request->from);
        $to = date_create($request->to);
        $loc = $request->server->get('HTTP_REFERER');

        if(date_diff($from,$to)->invert == 1){
            return "<script>alert('Inverted Selection! Invalid!'); window.location.href='$loc'</script>";
        }

        if(Auth::check()){
            $invoiceTable = DB::table('dealerinvoice')
                ->where('type', 'DEAL')
                ->whereDate('date','>=',$request->from)
                ->whereDate('date','<=',$request->to)
                ->orderBy('date','DESC')
                ->paginate(15);

            return view('pages.invoice')
                ->with('fromDealer', 'Y')
                ->with('dates',['from'=>$request->from,'to'=>$request->to])
                ->with('invoiceTable', $invoiceTable);
        }
        else{
            return "ERROR! : PERMISSION DENIED";
        }
    }

//
//$invoices = DB::table('dealerinvoice')
//->where('type', 'DEAL')
//->orderBy('date')
//->paginate(15);


}

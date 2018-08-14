<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home')
                ->with('stocklevels',$this->getStockLevels())
                ->with('criticalitems',$this->getCriticalStocks())
                ->with('salesdetails',$this->getCustomerSales())
                ->with('passwd_age',$this->getAdminPasswordInfo());
    }


    private function getStockLevels(){
        if(Auth::check()){
            try{
                $items = DB::table('items')
                        ->join('stock','items.itemcode','stock.itemcode')
                        ->select('items.itemcode','items.price','stock.*')
                        ->get();

                $count = 0;
                $value = 0;
                foreach ($items as $item){
                    $count++;
                    $value = $value + ($item->price * $item->amount);
                }
                return ['count'=>$count,'value'=>$value];
            }catch (QueryException $e){
                return $e->getMessage();
            }
        }else{
            return null;
        }
    }

    private function getCriticalStocks(){
        if(Auth::check()){
            try{
                $items = DB::table('items')
                    ->join('stock','items.itemcode','stock.itemcode')
                    ->where('stock.amount','<',5)
                    ->select('items.itemcode','stock.*')
                    ->get();

                return $items;
            }catch (QueryException $e){
                return $e->getMessage();
            }
        }else{
            return null;
        }
    }

    private function getCustomerSales(){
        try{
            $result = DB::table('invoice')
                        ->whereMonth('date',date('m'))
                        ->get();

                        $count = 0;
                        $value = 0;
                        foreach ($result as $row){
                            $count++;
                            $value = $value + $row->amount;
                        }

                        return ['count'=>$count, 'value'=>$value];
        }
        catch (QueryException $e){
            return $e->getMessage();
        }
    }

    private function getAdminPasswordInfo()
    {
        try {
            $admin = DB::table('users')
                ->first();
            $updated_at = date_create($admin->updated_at);
            $exceed = false;
            $diff = 0;
            if ($updated_at < date_create(date('Y-m-d'))) {
                $exceed = true;
                $diff = date_diff($updated_at, date_create(date('Y-m-d')))->days;
            }
            return [
                'exceeded' => $exceed,
                'diff' => $diff
            ];
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }



}

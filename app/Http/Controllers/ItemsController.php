<?php

namespace App\Http\Controllers;

use DeepCopy\f008\A;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Data\Item;
use function Psy\sh;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class ItemsController extends Controller
{
    public function show(Request $request)
    {
        if (Auth::check()) {
            $this->checkStock();
            return view('pages/items')
                ->with('itemsTable', $this->getItemslist($request->orderby)!= "ERR" ? $this->getItemslist($request->orderby):$this->getItemslist(null))
                ->with('catArr', $this->getCategorylist())
                ->with('mainCatArr', $this->getMainCategorylist());
        } else
            return "Error 403: Forbidden";
    }

    private function getItemslist($value)
    {
        try{
            if(isset($value)){
                $itemsTable = DB::table('items')
                    ->join('stock', 'items.itemcode', '=', 'stock.itemcode')
                    ->orderBy($value,'ASC')
                    ->select('items.*', 'stock.*')
                    ->paginate(15);
            }
            else{
                $itemsTable = DB::table('items')
                    ->join('stock', 'items.itemcode', '=', 'stock.itemcode')
                    ->orderBy('items.itemcode','ASC')
                    ->select('items.*', 'stock.*')
                    ->paginate(15);
            }

        }
        catch (QueryException $e){
            return "ERR";
        }

        return $itemsTable;
    }

    public function search(Request $request){
        try{
            if($request->search == "")
                return $this->show(new Request());

            $itemsTable = DB::table('items')
                        ->where('items.name','like','%'.$request->search.'%')
                        ->orWhere('items.itemcode', 'like', '%'.$request->search.'%')
                        ->join('stock', 'items.itemcode', '=', 'stock.itemcode')
                        ->paginate(15);

            return view('pages/items')
                ->with('itemsTable',$itemsTable)
                ->with('searchtext',$request->search)
                ->with('catArr', $this->getCategorylist())
                ->with('mainCatArr', $this->getMainCategorylist());
        }
        catch (QueryException $e){
            return "ERR";
        }
    }

    private function checkStock()
    {
        try {
            $stock = DB::table('stock')
                ->get();

            foreach ($stock as $value) {
                if ($value->amount == 0) {
                    DB::table('stock')
                        ->where('itemcode', $value->itemcode)
                        ->update([
                            'instock' => 'NO'
                        ]);

                    DB::table('items')
                        ->where('itemcode', $value->itemcode)
                        ->update([
                            'enabled' => 'NO'
                        ]);
                }
            }

        } catch (QueryException $e) {
            return "SERVER ERROR";
        }
        return null;
    }

    private function getMainCategorylist()
    {
        $mainCategorylist = DB::table('maincategory')
            ->orderBy('name')
            ->get();
        $i = 0;
        foreach ($mainCategorylist as $row) {
            $arr[$i++] = $row->name;
        }
        return $arr;
    }

    private function getCategorylist()
    {
        $categoryTable = DB::table('subcategory')
            ->orderBy('maincategory')
            ->get();

        $i = 0;
        $j = 0;
        $oldCat = "";
        foreach ($categoryTable as $row) {
            if ($oldCat != $row->maincategory) {
                $i = 0;
                $j++;
            }
            $arr[$row->maincategory][$i++] = $row->subcategoryname;
            $oldCat = $row->maincategory;
        }
        return $arr;
    }


    public function add(Request $request)
    {
        if (Auth::check()) {
            $name = $request->input('name');
            $subheading = $request->input('subheading');
            $brandcode = $request->input('brand');
            $stocklevel = intval($request->input('stocklevel')) >= 0 ? intval($request->input('stocklevel')) : 0;
            $description = $request->input('description');
            $maincategory = $request->input('maincategory');
            $subcategory = $request->input('subcategory');
            $price = floatval($request->input('price'));
            $discount = floatval($request->input('discount')) <= 100 ? floatval($request->input('discount')) : 0.0;
            $warranty = $request->input('warranty');
            $duration = $request->input('duration');
            $warrantyString = $warranty . " " . $duration;
            $img1 = $request->file('productimage1');
            $img2 = $request->file('productimage2');
            $destination = public_path('/images/items');
            $itemcode = $this->generateItemCode($brandcode, $name);
            $md5 = md5_file($img1);


            try {
                $name1 = time() . '.' . random_int(10000, 99999) . '.' . $img1->getClientOriginalExtension();
                $img1->move($destination, $name1);

                $name2 = time() . '.' . random_int(10000, 99999) . '.' . $img2->getClientOriginalExtension();
                $img2->move($destination, $name2);

                if ($request->hasFile('productimage3')) {
                    $img3 = $request->file('productimage3');
                    $name3 = time() . '.' . random_int(10000, 99999) . '.' . $img3->getClientOriginalExtension();
                    $img3->move($destination, $name3);
                }
                if ($request->hasFile('productimage4')) {
                    $img4 = $request->file('productimage4');
                    $name4 = time() . '.' . random_int(10000, 99999) . '.' . $img4->getClientOriginalExtension();
                    $img4->move($destination, $name4);
                }
            } catch (FileNotFoundException $e) {
                return $e->getMessage();
            }
            try {
                DB::table('items')
                    ->insert([
                        'itemcode' => $itemcode,
                        'name' => $name,
                        'subheading' => $subheading,
                        'description' => $description,
                        'brandcode' => $brandcode,
                        'category' => $maincategory,
                        'subcategory' => $subcategory,
                        'price' => $price,
                        'discount' => $discount,
                        'warranty' => $warrantyString,
                        'enabled' => 'NO'
                    ]);

                sleep(1);

                DB::table('itemdetails')
                    ->insert([
                        'itemcode' => $itemcode,
                        'image_1' => $name1,
                        'image_2' => $name2,
                        'image_3' => isset($name3) ? $name3 : "",
                        'image_4' => isset($name4) ? $name4 : "",
                    ]);

                DB::table('stock')
                    ->insert([
                        'itemcode' => $itemcode,
                        'instock' => "NO",
                        'amount' => 0,
                    ]);

                DB::table('maincart')
                    ->insert([
                        'itemcode'=>$itemcode,
                        'quantity'=>$stocklevel,
                        'fromdealer'=>'Y'
                    ]);

                $optionsTable = DB::table('options')
                    ->where('subcategory', $subcategory)
                    ->where('maincategory', $maincategory)
                    ->get();


                return view('innerpages.editoptions')
                    ->with('itemname', $name)
                    ->with('itemcode', $itemcode)
                    ->with('maincategory', $maincategory)
                    ->with('subcategory', $subcategory)
                    ->with('optionsTable', $optionsTable);

            } catch (QueryException $e) {
                return $e->getMessage();
            }


        }

        return "Forbidden 403";
    }


    private function generateItemCode($brandcode, $productname)
    {
        try {
            $productnamearray = explode(" ", $productname);
            return strtoupper($brandcode . "_" . $productnamearray[0] . "_" . $productnamearray[1] . "_" . random_int(1000, 9999));
        } catch (\OutOfBoundsException $e) {
            return "Array out of BOUNDS!";
        }

    }


    public function showItemAdd(Request $request)
    {

        try {
            $brandstable = DB::table('brands')
                ->get();
        } catch (QueryException $e) {

        }


        if (!isset($request->maincategory)) {
            return view('innerpages/additem')
                ->with(['maincategory' => 'Storage', 'subcategory' => 'SSD'])
                ->with('brandstable', $brandstable);
        }

        if (Auth::check()) {
            try {

                return view('innerpages/additem')
                    ->with(['maincategory' => $request->input('maincategory'),
                        'subcategory' => $request->input('subcategory')
                    ])
                    ->with('brandstable', $brandstable);

            } catch (QueryException $e) {
                return $e->getCode();
            }


        }
    }


    public function edit(Request $request)
    {
        $itemcode = $request->input('itemcode');
        try{
            $item = DB::table('items')
                ->where('itemcode',$itemcode)
                ->first();
            return view('innerpages.edititem')
                ->with('itemcode',$itemcode)
                ->with('item',$item);

        }catch (QueryException $e){
            return $e->getMessage();
        }

    }

    public function update(Request $request){
        if(Auth::check()){
            try{
                DB::table('items')
                    ->where('itemcode',$request->itemcode)
                    ->update([
                       'subheading'=>$request->subheading,
                       'price'=>$request->price,
                       'discount'=>$request->discount,
                       'description'=>$request->description,
                    ]);
                return "<script>alert('Item modified successfully!'); window.close();</script>";
            }
            catch (QueryException $exception){
                return $exception->getMessage();
            }
        }else{
            return "Error 403: Access Denied!";
        }
    }

    public function showSelect()
    {
        if (Auth::check()) {
            try {
                $result = DB::table('maincategory')
                    ->paginate(10);

                return view('innerpages/selectcat')
                    ->with('maincategorytable', $result);
            } catch (QueryException $e) {
                return "Error!";
            }

        }
        return "Access Denied!";
    }

    public function addMainCat(Request $request)
    {
        if (Auth::check()) {
            try {
                DB::table('maincategory')
                    ->insert([
                        'name' => $request->maincat,
                    ]);

//                return redirect('/items/init',302,['rtr'=>'success',]);
                return redirect()->action('ItemsController@showSelect', ['rtr' => 'success']);

            } catch (QueryException $exception) {
                return "<script LANGUAGE='JavaScript'>window.alert('Cannot Insert Duplicates!');
                            window.location.href='/items/init';
                            </script>";
            }
        }
    }

    public function showSelect2(Request $request)
    {
        if (Auth::check()) {
            try {
                $result = DB::table('subcategory')
                    ->where('maincategory', $request->maincategory)
                    ->paginate(10);

                return view('innerpages/selectcat2')
                    ->with('subcategorytable', $result)
                    ->with('maincategory', $request->maincategory);
            } catch (QueryException $e) {
                return "Error!";
            }

        }
    }

    public function addSubCat(Request $request)
    {
        if (Auth::check()) {
            try {
                DB::table('subcategory')
                    ->insert([
                        'subcategoryname' => $request->subcat,
                        'maincategory' => $request->maincategory,
                    ]);

                return $this->showSelect2($request);

            } catch (QueryException $e) {
                return $this->showSelect2($request)->with(['error' => 1]);
            }
        }
    }

    public function removeSubCat($data)
    {
        $maincategory = explode(":", $data)[0];
        $subcategory = explode(":", $data)[1];

        $request = new Request(['maincategory' => $maincategory], ['maincategory' => $maincategory,]);

        try {
            DB::table('subcategory')
                ->where('subcategoryname', $subcategory)
                ->where('maincategory', $maincategory)
                ->delete();

            return $this->showSelect2($request);
        } catch (QueryException $exception) {
            return "<code>Unknown Exception Occurred. Close this window and try again.</code>";
        }

//        return dump($request);
    }


    public function modifyOptions(Request $request)
    {
//        return var_dump($request->input());

        $itemcode = $request->itemcode;
        $subcategory = $request->subcategory;
        $maincategory = $request->maincategory;

        try {
            $optionsTable = DB::table('options')
                ->where('subcategory', $subcategory)
                ->where('maincategory', $maincategory)
                ->select('options.name')
                ->get();

//            return var_dump($optionsTable);
            $count = 1;
            $arr = array();
            foreach ($optionsTable as $option) {
                $tmp = str_replace(' ', '_', $option->name);
                $value = $option->name . ":" . $request->input((string)$tmp);
                $index = strval("option" . strval($count));
                $arr[$index] = $value;
                $count++;
            }

//            return var_dump($arr);

            DB::table('itemdetails')
                ->where('itemcode', $itemcode)
                ->update($arr);

            return "<script type='text/javascript'>
                            alert('$itemcode Added Successfully!');
                            window.close();
                        </script>";

        } catch (QueryException $e) {
            return $e->getMessage();
        }

    }

    public function viewItem(Request $request)
    {
        if (Auth::check()) {
            $itemcode = $request->itemcode;
            try {

                $images = DB::table('itemdetails')
                            ->where('itemcode',$itemcode)
                            ->select('image_1','image_2','image_3','image_4')
                            ->first();

                $item = DB::table('items')
                    ->where('itemcode', $itemcode)
                    ->first();

                $itemDetails = DB::table('itemdetails')
                    ->where('itemcode', $itemcode)
                    ->first();

                $stock = DB::table('stock')
                    ->where('itemcode', $itemcode)
                    ->first();

                return view('innerpages.showitem')
                    ->with('item', $item)
                    ->with('itemdetails', $itemDetails)
                    ->with('stock', $stock)
                    ->with('images',$images);


            } catch (QueryException $e) {
                return $e->getMessage();
            }


        } else {
            return redirect('/');
        }
    }

    public function disable($itemcode)
    {
        if (Auth::check()) {
            try {
                DB::table('items')
                    ->where('itemcode', $itemcode)
                    ->update([
                        'enabled' => "NO",
                    ]);

                return redirect('/pages/items');
            } catch (QueryException $e) {
                return $e->getMessage();
            }
        }
        return "Error 403 : Permission Denied";
    }

    public function enable($itemcode)
    {
        if (Auth::check()) {
            try {
                DB::table('items')
                    ->where('itemcode', $itemcode)
                    ->update([
                        'enabled' => "YES",
                    ]);

                return redirect('/pages/items');
            } catch (QueryException $e) {
                return $e->getMessage();
            }
        }
        return "Error 403 : Permission Denied";
    }

    public function showRestockDialog(Request $request){
        if(Auth::check()){
            return view('innerpages.showrestockdialog')
                ->with('itemcode',$request->itemcode);
        }
        else{
            return "Error 403: Permission Denied!";
        }
    }


    public function restockrequest(Request $request){
        if(Auth::check()){
            if($request->input('stockamount') <= 0){
                $loc = $request->server->get('HTTP_REFERER');
                return "<script>alert('Invalid Stock amount! Try again'); window.location.href='$loc';</script>";
            }
            else{
                try{
                    DB::table('maincart')
                        ->insert([
                            'itemcode' => $request->input('itemcode'),
                            'quantity' => $request->input('stockamount'),
                            'fromdealer' => 'Y'
                        ]);

                    return "<script>alert('Restock request added! see Dealer Cart.'); window.close();</script>";
                }
                catch (QueryException $e){
                    return "Server Error!";
                }
            }
        }
        else{
            return "Error 403: Permission Denied!";
        }
    }


    public function generateInventoryList(){
        if(Auth::check()){
            try{
                $itemsTable = DB::table('items')
                                    ->join('stock', 'items.itemcode', '=', 'stock.itemcode')
                                    ->orderBy('items.itemcode','ASC')
                                    ->select('items.*', 'stock.*')
                                    ->get();

                $count = DB::table('items')
                            ->count();

                $total = 0;

                foreach ($itemsTable as $row){
                    $total += $row->price * $row->amount;
                }

                return view('innerpages.inventoryreport')
                        ->with('itemstable',$itemsTable)
                        ->with('count',$count)
                        ->with('total',$total);
            }
            catch (QueryException $e){
                return $e->getMessage();
            }
        }
        return "Forbidden!";
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OptionsController extends Controller
{
    public function show($value){
        if(Auth::check()) {
            $mainCategory = explode(",", $value)[0];
            $subCategory = explode(",", $value)[1];

            return view('innerpages/addoption')
                    ->with('mainCategory',$mainCategory)
                    ->with('subCategory',$subCategory);
        }

    }

    public function add(Request $request){
        if(Auth::check()){
            $main = $request->mainCategory;
            $sub = $request->subCategory;
            $option = $request->option;

            if(!isset($option)){
                return "<script LANGUAGE='JavaScript'>window.alert('Cannot Insert Blanks!');
                            window.location.href='/pages/categories/edit/subcat/$main,$sub';
                            </script>";
            }
                try{
                    $result = DB::table('options')
                        ->where('maincategory',$main)
                        ->where('subcategory',$sub)
                        ->where('name',$option)
                        ->count();
                if($result > 0){
                    return "<script LANGUAGE='JavaScript'>window.alert('Cannot Insert Duplicates!');
                            window.location.href='/pages/categories/edit/subcat/$main,$sub';
                            </script>";
                }
                else{
                    DB::table('options')
                        ->insert([
                            'maincategory'=>$main,
                            'subcategory'=>$sub,
                            'name'=>$option
                        ]);

                    return redirect()->action('SubCategoriesController@subCatEditShow',['mainCategory'=>$main.",".$sub]);
                }

                }catch(QueryException $e){
                    return $e->getMessage();
                }
        }
    }


    public function update(Request $request){

        $mainCategory = $request->input('mainCategory');
        $subCategory = $request->input('subCategory');
        $length = $request->input('length');
        $data = "";
        for($i=0; $i<$length; $i++){
            if($request->has($i) && isset($request->$i)){
                $data = $data.",".$request->$i;
            }
        }

        $optionsArray = explode(",",$data);
        $temp = "";
        try {
            //Delete existing options for a sub-category

            DB::table('options')
                ->where('subcategory', $subCategory)
                ->where('maincategory', $mainCategory)
                ->delete();
        }catch (QueryException $e){
            return $e->getMessage();
        }
        foreach ($optionsArray as $item){
            if(isset($item) && $item != ""){
                $temp = $temp."-".$item;
                try{
                    //Add new options to the table
                    DB::table('options')
                        ->insert([
                            'name'=>$item,
                            'subcategory'=>$subCategory,
                            'maincategory'=>$mainCategory
                        ]);
                }
                catch (QueryException $exception){
                    return $exception->getMessage();
                }
            }
        }
//        return $temp;
        return redirect()->back();
    }

}

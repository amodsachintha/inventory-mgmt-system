<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    public function add(Request $request)
    {
        if (isset($request->name)) {
            if (trim($request->name) != "") {
                try {
                    DB::table('subcategory')
                        ->insert(
                            ['subcategoryname' => $request->name, 'maincategory' => $request->mainCat]
                        );

                } catch (QueryException $e) {
                    if ($e->getCode() == "23000")
                        return "<script LANGUAGE='JavaScript'>alert('Cannot Insert Duplicates!');
                    window.location.href='/pages/categories/?maincategory=$request->mainCat';
                    </script>";
                    else
                        return "<script LANGUAGE='JavaScript'>alert('Server Error!');
                    window.location.href='/pages/categories/?maincategory=$request->mainCat';
                    </script>";

                }
            }
        }
        else{
            return "<script LANGUAGE='JavaScript'>alert('Invalid Input!');
                    window.location.href='/pages/categories/?maincategory=$request->mainCat';
                    </script>";
        }

        return redirect()->action('CategoriesController@show', ['maincategory' => $request->mainCat]);
    }

    public function subCatEditShow($mainCategory)
    {
        if (Auth::check()) {
            try {
                $arr = explode(",", $mainCategory);
                $subCatOptionsTable = DB::table('options')
                    ->where('maincategory', $arr[0])
                    ->orderBy('subcategory')
                    ->get();

                $currentOptions = DB::table('options')
                    ->where('subcategory', $arr[1])
                    ->get();

//                return var_dump($currentOptions);
            } catch (QueryException $qe) {
                return abort(500, "Error!");
            }

            return view('innerpages/addsubcategory')
                ->with('mainCategory', $arr[0])
                ->with('subCategory', $arr[1])
                ->with('subCatOptionsTable', $subCatOptionsTable)
                ->with('currentOptions', $currentOptions);
        } else
            return abort(500, "Error");
    }


    public function edit($subCat)
    {
        if (Auth::check()) {

        }
    }


    public function delete($subCat)
    {
        if (Auth::check()) {
            try {
                DB::table('subcategory')
                    ->where('subcategoryname', $subCat)
                    ->delete();

                return back();
            } catch (QueryException $e) {
                return "<script LANGUAGE='JavaScript'>alert('Server Error! code: $e->getCode()');
                    window.location.href='/pages/categories/';
                    </script>";
            }
        }
    }

}

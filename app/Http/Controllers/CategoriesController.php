<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function show(Request $request)
    {
        if (Auth::check()) {
            if (isset($request->maincategory)) {
                return view('pages/categories')
                    ->with('mainCategories', $this->getMainCategories())
                    ->with('subcategories', $this->getSubCategories($request->maincategory))
                    ->with('returnCategory', $request->maincategory);
            } else {
                return view('pages/categories')
                    ->with('mainCategories', $this->getMainCategories());
            }

        } else
            return "Error 403: Forbidden";
    }


    private function getMainCategories()
    {
        try {
            return DB::table('maincategory')
                ->orderBy('name')
                ->get();

        } catch (QueryException $qe) {
            return "Error 500";
        }
    }

    private function getSubCategories($mainCategory)
    {
        try {
            return DB::table('subcategory')
                ->where('maincategory', $mainCategory)
                ->orderBy('subcategoryname')
                ->get();

        } catch (QueryException $qe) {
            return "Error 500";
        }
    }

    public function addNew(Request $request)
    {

        try {
            $loc = $request->server->get("HTTP_REFERER");
            if (trim($request->maincategory) != "") {
                DB::table('maincategory')
                    ->insert([
                        'name' => $request->maincategory,
                    ]);

                return "<script>alert('$request->maincategory added successfully!'); window.location.href='$loc'</script>";
            } else {
                return "<script>alert('Invalid Input!!'); window.location.href='$loc'</script>";
            }
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }


}

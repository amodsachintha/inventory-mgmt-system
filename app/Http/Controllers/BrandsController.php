<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class BrandsController extends Controller
{
    public function show(Request $request)
    {
        if (Auth::check()) {
            return view('pages/brands')
                ->with('searchtext',$request->search)
                ->with('brandsTable', $this->getBrandsTable($request));
        }
    }


    private function getBrandsTable(Request $request)
    {
        try {
            if(isset($request->search)){
                return DB::table('brands')
                    ->where('brandcode','like','%'.$request->search.'%')
                    ->orWhere('name','like','%'.$request->search.'%')
                    ->orderBy('brandcode')
                    ->paginate(15);
            }
            else {
                return DB::table('brands')
                    ->orderBy('brandcode')
                    ->paginate(15);
            }
        } catch (QueryException $exception) {
            return $exception->getMessage();
        }
    }


    public function showedit($brandcode)
    {
        if (Auth::check()) {

            try {
                $result = DB::table('brands')
                    ->where('brandcode', $brandcode)
                    ->first();

                if(!isset($result)){
                    return "<script type='text/javascript'>alert('Invalid brand code!'); window.close();</script>";
                }

                return view('innerpages/editbrand')
                    ->with('brandcode', $brandcode)
                    ->with('brandsRow', $result);
            } catch (QueryException $e) {
                return "<script type='text/javascript'>alert('$e->getCode()')</script>";
            }

        }
    }

    public function add(Request $request)
    {
        if (Auth::check()) {
            if (isset($request->brandlogo)) {
                try {
                    $image = $request->file('brandlogo');
                    $name = time() . '.' . random_int(10000, 99999) . '.' . $image->getClientOriginalExtension();
                    $destination = public_path('/images/brandlogos');
                    $image->move($destination, $name);
                } catch (FileNotFoundException $e) {
                    return $e->getMessage();
                }
                try {
                    DB::table('brands')
                        ->insert([
                            'name' => $request->input('brandname'),
                            'brandcode' => strtoupper($request->input('brandcode')),
                            'brandlogo' => $name,
                        ]);
                } catch (QueryException $exception) {
                    return "<script LANGUAGE='JavaScript'>window.alert('Cannot Insert Duplicates!');
                            window.location.href='/pages/brands';
                            </script>";
                }

                return "<script type='text/javascript'>alert('Brand added successfully!'); if(window.opener){ window.close();} else window.location.href='/pages/brands';</script>";
            }
        }
    }

    public function delete(Request $request)
    {
        if (Auth::check()) {
            try {
                DB::table('brands')
                    ->where('brandcode', $request->brandcode)
                    ->delete();

                return back();
            } catch (QueryException $e) {
                return $e->getMessage();
            }
        }
    }


    public function edit(Request $request){
        if(Auth::check()){
            DB::table('brands')
                ->where('brandcode',$request->oldbrandcode)
                ->delete();

            return $this->add($request);
        }
    }


}

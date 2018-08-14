<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProfileController extends Controller
{

    public function show(Request $request)
    {
        if (Auth::check()) {
            if (isset($_GET['fromDashboard'])) {
                return view('pages.profile')
                    ->with('dateinfo', $this->getAdminPasswordInfo())
                    ->with('admin', $this->getAdmin())
                    ->with('fromDashboard',true);
            } else {
                return view('pages.profile')
                    ->with('dateinfo', $this->getAdminPasswordInfo())
                    ->with('admin', $this->getAdmin());
            }
        } else {
            return "Error 403: Permission Denied!";
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

    private function getAdmin()
    {
        try {
            return DB::table('users')
                ->first();
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public static function getAvatar()
    {
        try {
            return DB::table('users')
                ->first()->avatar;

        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }


    public function updatePasswd(Request $request)
    {
        //CURRENT PASSWORD = QCf43@$2fcs
        if (Auth::check()) {
            $loc = $request->server->get('HTTP_REFERER');
            try {
                $this->validate($request, [
                    'password1' => 'required|string|min:10',
                    'password2' => 'required|string|min:10',
                ]);
                if (strcmp($request->input('password1'), $request->input('password2')) == 0) {
                    if (str_contains($request->input('password1'), ['$', '@', '#', '!', '%'])) {
                        if (str_contains($request->input('password1'), ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'])) {
                            if (str_contains($request->input('password1'), ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'])) {
                                if (str_contains($request->input('password1'), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',])) {
                                    if ($this->doPasswordUpdate($request->input('password1')) == 0) {
                                        return "<script>alert('Password updated Successfully!'); window.location.href='$loc'</script>";
                                    } else {
                                        return "<script>alert('Unknown Error!! Password update Failed!!'); window.location.href='$loc'</script>";
                                    }
                                } else {
                                    return $this->javaScriptError($loc);
                                }
                            } else {
                                return $this->javaScriptError($loc);
                            }
                        } else {
                            return $this->javaScriptError($loc);
                        }
                    } else {
                        return $this->javaScriptError($loc);
                    }
                } else {
                    return "<script>alert('Passwords do not match!!');window.location.href='$loc';</script>";
                }
            } catch (ValidationException $e) {
                $m = $e->getMessage();
                return "<script>alert('Passwords do not match minimum length Criteria of 10 characters!');window.location.href='$loc';</script>";
            }
        }
        return "Error 403: Permission Denied";
    }

    private function javaScriptError($loc)
    {
        return "<script>alert('Password does not meet the set requirements! Make sure it contains at least one from each types: [ special characters , Upper Case, Lower Case, Numbers]');
                        window.location.href='$loc';
                        </script>";
    }

    private function doPasswordUpdate($newPassword)
    {
        try {
            DB::table('users')
                ->where('name', '=', 'admin')
                ->update([
                    'password' => bcrypt($newPassword),
                    'updated_at' => Carbon::now(),
                ]);
            return 0;
        } catch (QueryException $e) {
            return -1;
        }
    }


    public function updateProfile(Request $request)
    {
        if (Auth::check()) {
            $loc = $request->server->get('HTTP_REFERER');
            try {
                $fullname = $request->input('fullname') != "" ? $request->input('fullname') : null;
                $email = $request->input('email') != "" ? $request->input('email') : null;
                $old_email = $request->input('old_email');
                $old_fullname = $request->input('old_fullname');
                $avatar = $request->file('avatar');
                if ($request->hasFile('avatar') && isset($avatar) && $avatar != null) {
                    $name = time() . '_' . str_random(8) . '.' . $avatar->getClientOriginalExtension();
                    $avatar->move(public_path("/images/avatars"), $name);
                    DB::table('users')
                        ->where('name', 'admin')
                        ->update([
                            'avatar' => $name,
                        ]);
                    $im = 1;
                }
                if ($old_email != $email) {
                    DB::table('users')
                        ->where('name', 'admin')
                        ->update([
                            'email' => $email,
                        ]);

                    $em = 1;
                }

                if ($old_fullname != $fullname) {
                    DB::table('users')
                        ->where('name', 'admin')
                        ->update([
                            'fullname' => $fullname,
                        ]);
                    $fname = 1;
                }
            } catch (QueryException $e) {
                return var_dump($e);
            }

            if (isset($fname) || isset($im) || isset($em)) {
                return "<script>alert('Stats updated successfully!'); window.location.href='$loc';</script>";
            } else {
                return "<script>alert('Nothing to update!'); window.location.href='$loc';</script>";
            }

        }

        return "Error 403: Permission Denied";
    }

}

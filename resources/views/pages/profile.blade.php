@extends('layouts.app')

@section('content')
    <div class="container" xmlns:-webkit-filter="http://www.w3.org/1999/xhtml">
        @if(!isset($fromDashboard))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Admin Profile
                        </div>
                        <div class="panel-body">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <input type="hidden" name="old_fullname" value="{{$admin->fullname}}">
                                <input type="hidden" name="old_email" value="{{$admin->email}}">
                                <div align="center">
                                    <img src="/images/avatars/{{$admin->avatar}}" height="200" style="border-radius: 100px; -webkit-filter: drop-shadow(0px 0px 5px gray);">
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Full name</label>
                                    <input type="text" name="fullname" value="{{$admin->fullname}}" id="fullname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Login email</label>
                                    <input type="email" name="email" value="{{$admin->email}}" id="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="avatar">Profile image</label>
                                    <input type="file" name="avatar" id="avatar">
                                </div>
                                <div align="center" style="margin-top: 20px">
                                    <input type="submit" value="Update Changes" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-bottom: 60px">
                @if(isset($dateinfo['diff']) && $dateinfo['diff'] < 30)
                    <div class="panel panel-success">
                        @else
                            <div class="panel panel-danger">
                                @endif
                                <div class="panel-heading">
                                    Change Password | Password age: <kbd>{{$dateinfo['diff']}}</kbd>
                                </div>
                                <div class="panel-body">
                                    <form action="/profile/passwd" method="POST">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label for="password1">New password</label>
                                            <input type="password" name="password1" id="password1" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password2">Re-enter Password</label>
                                            <input type="password" name="password2" id="password2" class="form-control" required>
                                        </div>
                                        <div align="center" style="margin-top: 20px">
                                            <input type="submit" value="Update Changes" class="btn btn-danger">
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
@stop
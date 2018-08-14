@extends('layouts.app')

@section('content')
    <div class="container" xmlns:-webkit-filter="http://www.w3.org/1999/xhtml">
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <h1><strong>Dealers</strong></h1>
                    <h5>Supply Dealers of the company are listed here</h5>
                </div>
            </div>
            <div class="col-sm-4" align="right">
                <div style="margin-top: 50px">
                    <form action="/pages/dealers" method="GET">
                        <input type="text" placeholder="Search dealers.." name="search" required>
                        <input type="submit" value="Search" class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
        @if(isset($searchtext))
            <div class="row" style="margin-top: 10px; margin-bottom: 10px">
                <div class="col-md-8 col-md-offset-2" align="center">
                    <div class="text-success">Showing results for <strong><i>{{$searchtext}}</i></strong></div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md12">
                <form action="/dealers/add" method="POST">
                    {{csrf_field()}}
                    <table class="table table-responsive table-hover" style="text-align:center; -webkit-filter: drop-shadow(1px 2px 2px gray)">
                        <tr style="background-color: #e1e1e1">
                            <th style="text-align: center">Name</th>
                            <th style="text-align: center">Type</th>
                            <th style="text-align: center">Address</th>
                            <th style="text-align: center">email</th>
                            <th style="text-align: center">telephone</th>
                            <th style="text-align: center">invoices</th>
                            {{--<th style="text-align: center">disable</th>--}}
                        </tr>
                        @foreach($dealersTable as $dealer)
                            <tr style="background-color: #ffffff">
                                <td>{{$dealer->name}}</td>
                                <td>{{$dealer->type}}</td>
                                <td>{{$dealer->address}}</td>
                                <td>{{$dealer->email}}</td>
                                <td>{{$dealer->telephone}}</td>
                                <td><a href="/pages/invoice/dealer?dealerid={{$dealer->iddealers}}" class="btn btn-info">view</a></td>
                                {{--<td><a href="#">disable</a></td>--}}
                            </tr>
                        @endforeach
                        <tr style="background-color: #eeeeee">
                            <td><input type="text" name="name" placeholder="name.." class="form-control" required></td>
                            <td><select name="type" class="form-control">
                                    <option value="parts">Parts</option>
                                    <option value="wholesale">Wholesale</option>
                                    <option value="importer">Importer</option>
                                    <option value="broker">Broker</option>
                                </select></td>
                            <td><input type="text" name="address" placeholder="address.." class="form-control" required></td>
                            <td><input type="email" name="email" placeholder="email" class="form-control" required></td>
                            <td><input type="text" name="telephone" placeholder="telephone" class="form-control" onkeypress="return validate(event)" required></td>
                            <td colspan="1"><input type="submit" value="Add Dealer" class="btn btn-success"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>


    </div>

@stop
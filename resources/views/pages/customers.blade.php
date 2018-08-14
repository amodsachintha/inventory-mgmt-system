@extends('layouts.app')

@section('content')
    <div class="container" xmlns:-webkit-filter="http://www.w3.org/1999/xhtml">
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <h1><strong>Customers</strong></h1>
                    <h5>Registered Customers of the company are listed here</h5>
                </div>
            </div>
            <div class="col-sm-4" align="right">
                <div style="margin-top: 50px">
                    <form action="/pages/customers" method="GET">
                        <input type="text" placeholder="Search customers.." name="search" required>
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
            <div class="col-md-12">
                <form action="/customers/add" method="POST">
                    {{csrf_field()}}
                    <table class="table table-responsive table-hover"
                           style="text-align:center; -webkit-filter: drop-shadow(1px 2px 2px gray)">
                        <tr style="background-color: #e1e1e1">
                            <th style="text-align: center">Name</th>
                            <th style="text-align: center">Address</th>
                            <th style="text-align: center">email</th>
                            <th style="text-align: center">telephone</th>
                            <th style="text-align: center">invoices</th>
                            <th style="text-align: center">make sale</th>
                            {{--<th style="text-align: center">disable</th>--}}
                        </tr>
                        @foreach($customersTable as $customer)
                            <tr style="background-color: #ffffff">
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->address}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->telephone}}</td>
                                <td><a href="/pages/invoice/sales?custid={{$customer->idcustomers}}"
                                       class="btn btn-default">view</a></td>
                                <td><a href="/customers/generateinvoice?invCode={{$invCode}}:{{$customer->idcustomers}}"
                                       class="btn btn-info">make sale</a></td>
                                {{--<td><a href="#" class="btn btn-danger">disable</a></td>--}}
                            </tr>
                        @endforeach
                        <tr style="background-color: #eeeeee">
                            <td><input type="text" name="name" placeholder="name.." class="form-control" required></td>
                            <td><input type="text" name="address" placeholder="address.." class="form-control" required>
                            </td>
                            <td><input type="email" name="email" placeholder="email" class="form-control" required></td>
                            <td><input type="text" name="telephone" placeholder="telephone" class="form-control"
                                       onkeypress="return validate(event)" required></td>
                            <td colspan="2"><input type="submit" value="Add Customer" class="btn btn-success"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
@stop
@extends('layouts.app')

@section('content')

    <div class="container">
        @if($passwd_age['diff'] >= 30)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading"><strong>PASSWORD EXPIRED</strong></div>
                        <div class="panel-body">
                            <div class="text-danger"><h5>Your password is <strong>{{$passwd_age['diff']}}</strong> days old. Please update your password <a href="/pages/profile?fromDashboard=true">here</a></h5></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                        <br>
                        <a href="/pages/items">continue...</a>
                    </div>
                </div>
            </div>
        </div>
        @if(sizeof($criticalitems) != 0)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-danger">
                        <div class="panel-heading">Stock Critical Items</div>
                        <div class="panel-body">
                            @foreach($criticalitems as $item)
                                <p>
                                    <a href="#" onclick="return pop('/items/view?itemcode={{$item->itemcode}}','{{$item->itemcode}}')">{{$item->itemcode}} : {{$item->amount}} pcs</a>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Stock Summary</div>
                    <div class="panel-body">
                        <p>items count: {{$stocklevels['count']}}</p>
                        <p>total value: {{number_format($stocklevels['value'],2)}} LKR</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Total Customer Sales for <strong>{{date("F")}}</strong></div>
                    <div class="panel-body">
                        <p>Sale count: {{$salesdetails['count']}}</p>
                        <p>Sale value: {{number_format($salesdetails['value'],2)}} LKR</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

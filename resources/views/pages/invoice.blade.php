@extends('layouts.app')

@section('content')
    <div class="container" xmlns:-webkit-filter="http://www.w3.org/1999/xhtml">
        <div class="row">
            <div class="col-sm-12" align="center">
                <div>
                    <img src="/images/cart.png" width="25px">
                    @if($fromDealer == 'N')
                        <h1><strong>Sales Invoices</strong></h1>
                    @else
                        <h1><strong>Dealer Invoices</strong></h1>
                    @endif
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px; margin-bottom: 10px">
            <div class="col-md-6" align="center">
                <a href="/pages/invoice/sales" class="btn btn-default" style="width: 360px">Sales Invoices</a>
            </div>
            <div class="col-md-6" align="center">
                <a href="/pages/invoice/dealer" class="btn btn-default" style="width: 360px">Dealer Invoices</a>
            </div>
        </div>

        <div class="row" style="margin-bottom: 20px; margin-top: 20px">
            <div class="col-md-12" align="center">

                <form action="#" method="POST">
                    {{csrf_field()}}
                    From: <input type="date" name="from" autocomplete="true" required>
                    To: <input type="date" name="to" required>
                    <input type="submit" value="Go!">
                </form>

            </div>
        </div>
        @if(isset($dates))
            <div class="row">
                <div class="col-md-8 col-md-offset-2" align="center">
                    <p class="text-success">Displaying invoices from <strong>{{$dates['from']}}</strong> to <strong>{{$dates['to']}}</strong></p>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-1">
            </div>

            <div class="col-md-10">
                <table class="table table-hover table-responsive"
                       style=" -webkit-filter: drop-shadow(1px 2px 2px gray)">
                    <tr style="background-color: #e1e1e1; text-align: center">
                        <th>Inv. ID</th>
                        @if($fromDealer == 'N')
                            <th><a href="/pages/invoice/sales?orderby=invoicecode">Inv. Code</a></th>
                            <th><a href="/pages/invoice/sales?orderby=customerid">Cust. ID</a></th>
                            <th><a href="/pages/invoice/sales?orderby=amount">Amount</a></th>
                            <th><a href="/pages/invoice/sales?orderby=date">Date</a></th>
                        @else
                            <th><a href="/pages/invoice/dealer?orderby=invoicecode">Inv. Code</a></th>
                            <th><a href="/pages/invoice/dealer?orderby=dealerid">Dealer ID</a></th>
                            <th><a href="/pages/invoice/dealer?orderby=fullamount">Amount</a></th>
                            <th><a href="/pages/invoice/dealer?orderby=date">Date</a></th>
                        @endif

                    </tr>
                    @foreach($invoiceTable as $invoice)
                        <tr style="background-color: #ffffff">
                            <td>{{$invoice->idinvoice}}</td>
                            @if($fromDealer == 'N')
                                <td>
                                    <a href="/invoice/showsalesinvoice?invoicecode={{$invoice->invoicecode}}" target="_blank">{{$invoice->invoicecode}}</a>
                                </td>
                            @else
                                <td>
                                    <a href="/invoice/showdealernvoice?invoicecode={{$invoice->invoicecode}}" target="_blank">{{$invoice->invoicecode}}</a>
                                </td>
                            @endif
                            @if($fromDealer == 'N')
                                <td><a href="/pages/invoice/sales?custid={{$invoice->customerid}}"
                                       class="btn btn-info">{{$invoice->customerid}}</a></td>
                            @else
                                <td><a href="/pages/invoice/dealer?dealerid={{$invoice->dealerid}}" class="btn btn-info">{{$invoice->dealerid}}</a></td>
                            @endif
                            @if($fromDealer == 'N')
                                <td>{{number_format($invoice->amount,2)}} LKR</td>
                            @else
                                <td>{{number_format($invoice->fullamount,2)}} LKR</td>
                            @endif

                            <td>{{$invoice->date}}</td>
                        </tr>
                    @endforeach

                </table>
            </div>

            <div class="col-md-1">
            </div>

        </div>
        <div class="row">
            <div class="col-md-12" align="center">
                {{$invoiceTable->links()}}
            </div>
        </div>

@endsection
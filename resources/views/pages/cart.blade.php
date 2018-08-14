@extends('layouts.app')

@section('content')
    <div class="container" xmlns:-webkit-filter="http://www.w3.org/1999/xhtml">
        <div class="row">
            <div class="col-sm-12" align="center">
                <div>
                    <img src="/images/cart.png" width="25px">
                    @if($fromDealer == 'N')
                        <h1><strong>Sales Cart</strong></h1>
                    @else
                        <h1><strong>Dealer Cart</strong></h1>
                    @endif
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px; margin-bottom: 10px">
            <div class="col-md-6" align="center">
                <a href="/pages/cart/sales" class="btn btn-default" style="width: 360px">Sales Cart</a>
            </div>
            <div class="col-md-6" align="center">
                <a href="/pages/cart/dealer" class="btn btn-default" style="width: 360px">Dealer Cart</a>
            </div>
        </div>

        <div class="row" align="center">
            <div class="col-md-1">

            </div>
            <div class="col-md-10" align="center">

                    <table class="table table-hover" style="text-align: center; -webkit-filter: drop-shadow(1px 2px 2px gray)">
                        <tr style="background-color: #e1e1e1">

                            <td><strong>itemcode</strong></td>
                            <td><strong>name</strong></td>
                            <td><strong>quantity</strong></td>
                            <td><strong>price</strong></td>
                            @if($fromDealer == 'N')
                                <td><strong>discount</strong></td>
                            @endif
                            <td><strong>subtotal</strong></td>
                            <td><strong>remove</strong></td>
                        </tr>
                        <?php $sub = 0; ?>
                        @foreach($cartTable as $cartItem)
                            <tr style="background-color: #ffffff">
                                <td><a href="#" onclick="return pop('/items/view?itemcode={{$cartItem->itemcode}}','{{$cartItem->itemcode}}')">{{$cartItem->itemcode}}</a></td>
                                <td>{{$cartItem->name}}</td>
                                @if($fromDealer == 'N')
                                    <td><strong><a href="/cart/minus?itemcode={{$cartItem->itemcode}}" style="background-color: #e5e5e5; padding: 3px; border-radius: 3px;">&nbsp;- </a>&nbsp;
                                            <kbd>{{$cartItem->quantity}}</kbd> &nbsp;<a href="/cart/add?itemcode={{$cartItem->itemcode}}"
                                                                                        style="background-color: #e5e5e5; padding: 3px; border-radius: 3px">&nbsp+ </a></strong></td>
                                @else

                                    <td><code>{{$cartItem->quantity}}</code></td>
                                @endif
                                <td>{{number_format($cartItem->price,2)}} LKR</td>
                                @if($fromDealer == 'N')
                                    <td>{{$cartItem->discount}} %</td>
                                @endif
                                @if($fromDealer == 'N')
                                    <td>{{number_format($temp = $cartItem->price * $cartItem->quantity * ((100 - $cartItem->discount)/100.0),2)}} LKR</td>
                                @else
                                    <td>{{number_format($temp = $cartItem->price * $cartItem->quantity,2)}} LKR</td>
                                @endif
                                <?php $sub = $sub + $temp; ?>
                                <td><a href="/cart/remove?itemcode={{$cartItem->itemcode}}" class="btn btn-danger" onclick="return confirm('Are you sure?')">remove</a></td>
                            </tr>
                        @endforeach
                        <tr style="background-color: #e8fdd0; color: #1b1e21">
                            @if($fromDealer == 'N')
                                <td colspan="4" style="text-align: right"><h4>Total</h4></td>
                            @else
                                <td colspan="3" style="text-align: right"><h4>Total</h4></td>
                            @endif
                            <td colspan="2"><h4>{{number_format($sub,2)}} LKR</h4></td>
                            <td colspan="1">
                                @if($sub == 0)
                                    <a href="#" class="btn btn-primary" disabled="true">Generate Invoice</a>
                                @else
                                    @if($fromDealer == 'N')
                                        <a href="#" onclick="return pop('/invoice/generatesalesinvoice?invCode={{$invCode}}',' ')" class="btn btn-primary">Generate Invoice</a>
                                    @else
                                        <a href="#" onclick="return pop('/invoice/generatedealerinvoice?invCode={{$invCode}}',' ')" class="btn btn-primary">Generate Invoice</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        <tr style="background-color: #e1e1e1">
                            <td colspan="7"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="col-md-1">

            </div>
        </div>
    </div>
@stop
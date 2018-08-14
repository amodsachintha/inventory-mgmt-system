@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        function pop(url, name) {
            newwindow = window.open(url, 'name', 'height=500,width=400');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }
    </script>
    <div class="container" style="margin-bottom: 40px">
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <h1><strong>Items</strong></h1>
                    <h5>All items in the inventory are shown here</h5>
                </div>
            </div>
            <div class="col-sm-4" align="right">
                <div style="margin-top: 50px">
                    <form action="/search/item" method="GET">
                        <input type="text" placeholder="Search items.." name="search" class="form-text" style="width: 200px">
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
            <div class="col-md-12" align="center">
                <table class="table table-responsive table-hover"
                       style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; text-align: center">
                    <tr style="background-color: #efefef">
                        <td><b><a href="/pages/items?orderby=items.itemcode">item_code</a></b></td>
                        <td><b><a href="/pages/items?orderby=items.name">name</a></b></td>
                        <td><b><a href="/pages/items?orderby=items.brandcode">brand_code</a></b></td>
                        <td><b><a href="/pages/items?orderby=items.subcategory">sub_cat</a></b></td>
                        <td><b><a href="/pages/items?orderby=items.price">price</a></b></td>
                        {{--<td><b>discount%</b></td>--}}
                        <td><b>amount</b></td>
                        <td><b>edit</b></td>
                        <td><b>disable</b></td>
                        <td><b><kbd>cart+</kbd></b></td>
                        {{--<td><b><code>cart+</code></b></td>--}}
                    </tr>

                    @if(sizeof($itemsTable) == 0)
                        <tr style="background-color: #ffffff; font-family: Verdana">
                            <td colspan="9" align="center"><p class="text-danger">Sorry! No results!</p></td>
                        </tr>
                    @endif

                    @foreach($itemsTable as $item)
                        @if($item->enabled == "NO")
                            <tr style="background-color: #090909; font-family: Verdana">
                        @else
                            <tr style="background-color: #ffffff; font-family: Verdana">
                                @endif
                                <td><a href="#"
                                       onclick="return pop('/items/view?itemcode={{$item->itemcode}}','{{$item->itemcode}}')">{{$item->itemcode}}</a>
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->brandcode}}</td>
                                <td>{{$item->subcategory}}</td>
                                <td>{{number_format($item->price)}} LKR</td>
                                    {{--<td>{{$item->discount}}</td>--}}
                                @if(intval($item->amount) < 5)
                                    <td style="background-color: #843534; color: #ffffff">{{$item->amount}}</td>
                                @elseif(intval($item->amount) < 10)
                                    <td style="background-color: #e8d500">{{$item->amount}}</td>
                                @else
                                    <td style="background-color: #0ebe00">{{$item->amount}}</td>
                                @endif

                                <td><a href="#" onclick="return pop('/items/edit?itemcode={{$item->itemcode}}',' ')" class="btn btn-default">edit</a></td>
                                @if($item->enabled == "YES")
                                    <td><a href="/items/disable/{{$item->itemcode}}"
                                           onclick="return confirm('Are you sure?')" class="btn btn-danger">disable</a></td>
                                @else
                                    <td><a href="/items/enable/{{$item->itemcode}}" class="btn btn-success">enable</a></td>
                                     <td><a href="#" class="btn btn-success" onclick="return pop('/items/restock?itemcode={{$item->itemcode}}','Restock')">restock</a></td>
                                @endif
                                    @if($item->enabled == "YES")
                                        <td><a href="/cart/add?itemcode={{$item->itemcode}}" class="btn btn-success">add</a></td>
                                        {{--<td><a href="/cart/addall?itemcode={{$item->itemcode}}" class="btn btn-warning">update</a></td>--}}
                                    @else
                                        {{--<td></td>--}}
                                    @endif
                            </tr>
                            @endforeach


                </table>
            </div>

        </div>
        <div class="row" align="center">
            {{$itemsTable->links()}}
        </div>
    </div>


@stop
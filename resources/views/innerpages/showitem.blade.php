<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>{{$item->itemcode}}</title>
</head>
<body style="padding: 20px">
<div class="container">
    <div class="row" align="center" style="font-family: Verdana;">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <kbd>{{$item->category}}</kbd> :
            <kbd>{{$item->subcategory}}</kbd>
            <div class="jumbotron-fluid">
                <h2>{{$item->name}}</h2>
                <p><strong>{{$item->itemcode}}</strong></p>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <div class="row" style="margin-top: 20px; margin-bottom: 20px; align-items: center" align="center">
        @if(isset($images))
            @foreach($images as $image)
                @if($image != null)
                    <div style="margin-right: 20px">
                        <img src="/images/items/{{$image}}" height="120">
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <div class="row" style="font-family: Verdana; margin-bottom: 30px">
        <div class="col-md-2">

        </div>
        <div class="col-md-8" style="padding-right: 5px">
            <table class="table table-responsive table-hover">
                <tr>
                    {{--<td>Subheading</td>--}}
                    <td colspan="2" style="text-align: center">{{$item->subheading}}</td>
                </tr>
                <tr>
                    <td><code>Brand code</code></td>
                    <td>{{$item->brandcode}}</td>
                </tr>
                <tr>
                    <td><code>Price</code></td>
                    <td>{{number_format($item->price,2)}} LKR</td>
                </tr>
                <tr>
                    <td><code>Discount</code></td>
                    <td>{{$item->discount}} %</td>
                </tr>
                <tr>
                    <td><code>Warranty</code></td>
                    <td>{{$item->warranty}}</td>
                </tr>
            </table>
            <code>Description</code>
            <?php echo $item->description ?>

            <table class="table table-responsive table-hover">
                <tr>
                    <td><code>Options</code></td>
                    <?php
                    $temp = "";
                    $i = 1;
                    foreach ($itemdetails as $detail) {
                        if ($i < 3 || $detail == "") {
                            $i++;
                            continue;
                        }
                        if ($i >= 16) {
                            break;
                        }
                        $temp = $temp . $detail . "&";
                        $i++;
                    }
                    $temp = explode("&", $temp);
                    ?>
                    <td>
                        @foreach($temp as $val)
                            {{$val}}<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td><code>In Stock</code></td>
                    <td>{{$stock->instock}}</td>
                </tr>
                <tr>
                    <td><code>Stock level</code></td>
                    @if(intval($stock->amount) < 5)
                        <td style="background-color: #843534; color: #ffffff">{{$stock->amount}}</td>
                    @elseif(intval($stock->amount) < 10)
                        <td style="background-color: #e8d500">{{$stock->amount}}</td>
                    @else
                        <td style="background-color: #0ebe00">{{$stock->amount}}</td>
                    @endif

                </tr>

                <tr>
                    <td><code>Enabled</code></td>
                    <td>{{$item->enabled}}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-2">

        </div>
    </div>
</div>
</body>
</html>
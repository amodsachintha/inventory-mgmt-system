<html>
<head>

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/images/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Inventory Report</title>
    <style>
        div {
            #border: solid #9ca2a6 1px;
        }
    </style>
</head>
<body style="margin-bottom: 30px">
<div class="container" style="border: solid #636b6f 1px; border-radius: 10px; padding: 20px; max-width: 1040px; margin: auto" align="center">
    <div class="row" style="border-bottom: solid #a3b1be 1px; font-family: Verdana, sans-serif">
        <div class="col-sm-4" align="right">
            <img src="/images/logo.jpg" height="150">
        </div>
        <div class="col-sm-4" align="left" style="text-align: center">
            <h2><strong>Dreamtech Computer Solutions</strong></h2>
        </div>
        <div class="col-sm-4" align="left">
            <p>Dreamtech Computer Solutions,<br>
                341/1/D,<br>
                Dawatagahawatta,<br>
                Thimbirigaskatuwa</p>
            <p>Contact: 0778453321<br>email: sales@dreamtech.lk</p>
        </div>
    </div>
    <div class="row" style="margin-top: 20px; margin-bottom: 20px; border-bottom: solid #a3b1be 1px;">
        <div class="col-sm-12" align="center">
            <h4><strong>Inventory Report</strong></h4>
            <p><code>Generated on: {{date("l jS \of F Y h:i:s A")}}</code></p>
        </div>
    </div>

    <div class="row" align="center">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4" align="center" style="#border-bottom: solid #a3b1be 1px;">
            <p><code>Summary</code></p>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
    <div class="row" style="margin-top: 10px; margin-bottom: 40px">
        <div class="col-sm-6">
            <p>Individual Item Count: <strong>{{$count}}</strong></p>
        </div>
        <div class="col-sm-6">
            <p>Total Value: <strong>{{number_format($total,2) }} LKR</strong></p>
        </div>
    </div>

    <div class="row" align="center" style="margin-top: 20px">
        <div class="col-md-12" align="center">
            <table class="table table-hover" style="width: available; text-align: center">
                <tr style="background-color: #efefef">
                    <th>itemcode</th>
                    <th>name</th>
                    <th>brandcode</th>
                    <th>subcategory</th>
                    <th>warranty</th>
                    <th>price</th>
                    <th>stock level</th>
                </tr>

                @foreach($itemstable as $row)
                    <tr>
                        <td>{{$row->itemcode}}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->brandcode}}</td>
                        <td>{{$row->subcategory}}</td>
                        <td>{{$row->warranty}}</td>
                        <td>{{number_format($row->price,2)}} LKR</td>
                        @if(intval($row->amount) < 5)
                            <td style="background-color: #843534; color: #ffffff">{{$row->amount}}</td>
                        @elseif(intval($row->amount) < 10)
                            <td style="background-color: #e8d500">{{$row->amount}}</td>
                        @else
                            <td style="background-color: #0ebe00">{{$row->amount}}</td>
                        @endif
                    </tr>
                @endforeach

            </table>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12" align="center">
            <a href="#" onclick="return hideMe();" class="btn btn-success" id="print">Print this!</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function hideMe() {

        var btn2 = document.getElementById('print');
        btn2.hidden = true;
        window.print();
        btn2.hidden = false;
    }
</script>

</div>
</body>
</html>
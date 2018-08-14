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
    <title>{{$invoicecode}}</title>
    <style>
        div {
            #border: solid #9ca2a6 1px;
        }
    </style>
</head>
<body>
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
            <h4><strong>CUSTOMER INVOICE</strong></h4>
            <kbd>{{$invoicecode}}</kbd>
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
        <div class="col-sm-4">
            <p>Invoice code: <strong>{{$invoicecode}}</strong></p>
        </div>
        <div class="col-sm-3">
            <p>Customer: <strong>{{$invoicerow->name}}</strong></p>
        </div>
        <div class="col-sm-2">
            <p>Total: <strong>{{number_format($invoicerow->amount,2)}} LKR</strong></p>
        </div>
        <div class="col-sm-3">
            <p>Date: <strong>{{$invoicerow->date}}</strong></p>
        </div>
    </div>

    <div class="row" align="center">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4" align="center" style="#border-bottom: solid #a3b1be 1px;">
            <p><code>Details</code></p>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
    <div class="row" align="center" style="margin-top: 20px">
        <div class="col-md-12" align="center">
            <table class="table table-hover" style="width: available; text-align: center">
                <tr style="background-color: #efefef">
                    <th>itemcode</th>
                    <th>unitprice</th>
                    <th>quantity</th>
                    <th>discount</th>
                    <th>subtotal</th>
                </tr>

                @foreach($invoicedetailtable as $row)
                    <tr>
                        <td>{{$row->itemcode}}</td>
                        <td>{{number_format($row->unitprice,2)}} LKR</td>
                        <td>{{$row->quantity}}</td>
                        <td>- {{number_format($row->discount,2)}} LKR</td>
                        <td>{{number_format($row->subtotal,2)}} LKR</td>
                    </tr>
                @endforeach

                <tr style="background-color: #F9F9F9">
                    <td colspan="4" style="text-align: right">Full Total</td>
                    <td>{{number_format($invoicerow->fullamount == null ? $invoicerow->amount+$invoicerow->discount:$invoicerow->fullamount,2)}} LKR</td>
                </tr>
                <tr style="background-color: #f9f9f9">
                    <td colspan="4" style="text-align: right">Total Discount</td>
                    <td>- {{number_format($invoicerow->discount,2)}} LKR</td>
                </tr>
                <tr style="background-color: rgba(210,218,239,0.54)">
                    <td colspan="4" style="text-align: right">Total</td>
                    <td><h3>{{number_format($invoicerow->amount,2)}} LKR</h3></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-4">
            <p>.......................................<br>Customer Signature</p>
        </div>
    </div>

    <div class="row" style="margin-top: 30px; margin-bottom: 30px; border-top: solid #636b6f 1px; padding-top: 30px">
        <div class="col-md-12" align="left">
            <div style="font-family: monospace">
                <h6>Conditions</h6>
                <p class="text-dark">Warranty Period may differ from item to item.<br>
                    Returned goods must be in the same condition it was purchased.<br>
                    Damages due to lightning, physical damages and natural disasters are not covered by Dreamtech.lk.
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <kbd>&copy; NetAsset&reg; {{date('Y')}}</kbd>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 30px; margin-bottom: 50px">
    <div class="col-md-12" align="center">
        <a href="/pages/invoice/sales" class="btn btn-primary" style="margin-right: 30px" id="back">back</a>
        <a href="#" onclick="return hideMe();" class="btn btn-success" id="print">Print this!</a>
    </div>
</div>

<script type="text/javascript">
    function hideMe() {
        var btn1 = document.getElementById('back');
        var btn2 = document.getElementById('print');
        btn1.hidden = true;
        btn2.hidden = true;
        window.print();
        btn1.hidden = false;
        btn2.hidden = false;
    }
</script>
</body>
</html>
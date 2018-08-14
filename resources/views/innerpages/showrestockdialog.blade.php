<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Restock {{$itemcode}}</title>
</head>
<body>
<div class="container" style="margin: 30px">
    <div class="row" style="margin-bottom: 20px">
        <div class="col-sm-12">
            <h3>Restock {{$itemcode}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="stockamount">Stock amount</label>
                    <input type="number" name="stockamount" id="stockamount" class="form-control" required value="1">
                </div>
                {{csrf_field()}}
                <input type="hidden" name="itemcode" value="{{$itemcode}}">
                <input type="submit" value="next" class="btn btn-dark" style="width:100px">
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>

</body>
</html>
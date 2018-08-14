<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Edit options</title>
</head>
<body style="padding: 20px">
<div class="container">
    <div class="row" align="center" style="font-family: Verdana; margin-bottom: 30px">
        <h2>Select</h2>
        <h3><strong>Main Category</strong></h3>
        <h4>the item belongs to..</h4>
    </div>
    <div class="row">
        <form action="/items/init1" method="POST">
            <table class="table">
                {{csrf_field()}}
                @foreach($maincategorytable as $row)
                    <tr>
                        <td><input type="radio" name="maincategory" value="{{$row->name}}" checked> {{$row->name}}</td>
                    </tr>
                @endforeach
                <input type="hidden" name="subcat" value="true">
                <tr>
                    <td align="center">{{$maincategorytable->links()}}</td>
                </tr>
                <tr>
                    <td align="center"><input type="submit" value="next >>" class="btn btn-primary"></td>
                </tr>
            </table>
        </form>
    </div>

    <div class="row" align="center" style="margin-top:20px">
        <form action="/items/init" method="POST">
            {{csrf_field()}}
            <input type="text" name="maincat" placeholder="or, add new!" class="text-info" required>
            <input type="submit" value="add" class="btn btn-success">
        </form>
    </div>
    @if(isset($rtr))
        <div class="row" align="center" style="margin-top: 20px">
            <div class="text-success">Main Category type added successfully!</div>
        </div>
    @endif
</div>

<script type="text/javascript">
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>

</body>
</html>
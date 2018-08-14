<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Edit options</title>
</head>
<body style="padding: 20px">
<div class="container">
    <div class="row" align="left">
        <kbd>{{$maincategory}}</kbd>
    </div>
    <div class="row" align="center" style="font-family: Verdana; margin-bottom: 10px">
        <h2>Select</h2>
        <h3><strong>Sub Category</strong></h3>
        <h4>the item belongs to..</h4>
    </div>

    <div class="row">
        <div class="col-md-4">
            <form action="/items/init2" method="POST">
                {{csrf_field()}}
                <table class="table">
                    <input type="hidden" name="maincategory" value="{{$maincategory}}">
                    @foreach($subcategorytable as $row)
                        <tr>
                            <td><input type="radio" required checked name="subcategory"
                                       value="{{$row->subcategoryname}}"> {{$row->subcategoryname}}</td>
                            <td align="center"><a href="#"
                                   onclick="if(confirm('Are you sure?')){
                                       window.location.href='/modrequest/remove/{{$maincategory.':'.$row->subcategoryname}}';
                                   }" class="btn btn-danger">remove</a></td>
                        </tr>
                    @endforeach
                    <tr><td colspan="2" align="center">{{$subcategorytable->links()}}</td></tr>
                    <tr>
                        <td align="center"><a href="/items/init" class="btn btn-primary"><< back</a></td>
                        <td><input type="submit" value="next >>" class="btn btn-primary"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    @if(isset($error) && $error==1)
        <div class="row" align="center">
            <div class="text-warning"><strong>Adding Sub Category failed due to duplicates!</strong></div>
        </div>
    @endif
    <div class="row" align="center" style="margin-top:20px">
        <form action="/items/initsub" method="POST">
            {{csrf_field()}}
            <input type="text" name="subcat" placeholder="or, add new!" class="text-info" required>
            <input type="hidden" name="maincategory" value="{{$maincategory}}">
            <input type="submit" value="add" class="btn btn-success">
        </form>
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
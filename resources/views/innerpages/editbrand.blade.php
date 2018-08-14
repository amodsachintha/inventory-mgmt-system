<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Edit options</title>
</head>
<body style="padding: 20px">
<div class="container">
    <div class="row">
        <div class="text-primary"><h3>Edit {{$brandcode}}</h3></div>
        <div class="text-info"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <form action="/brands/edit" enctype="multipart/form-data" method="POST">
                <table class="table table-responsive">
                    {{csrf_field()}}
                    <input type="hidden" name="oldbrandcode" value="{{$brandcode}}">
                    <tr>
                        <td>Brand name</td>
                        <td><input type="text" name="brandname" value="{{$brandsRow->name}}" required></td>
                    </tr>
                    <tr>
                        <td>Brand code</td>
                        <td><input type="text" name="brandcode" value="{{$brandsRow->brandcode}}" required></td>
                    </tr>
                    <tr>
                        <td>Brand Image</td>
                        <td><input type="file" name="brandlogo" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="Submit">
                        </td>
                    </tr>
                </table>
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

<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Edit options</title>
</head>
<body style="padding: 20px">
<div class="container">
    <div class="row">
        <div class="text-primary"><h3>Select Dealer</h3></div>
        <div class="text-info"></div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <form action="/invoice/generatedealerinvoice" method="POST">
                <table class="table table-hover">
                    <tr>
                        <th>name</th>
                        <th>type</th>
                        <th>email</th>
                        <th>telephone</th>
                        <th>select</th>
                    </tr>

                    @foreach($dealerTable as $dealer)
                        <tr>
                            <td>{{$dealer->name}}</td>
                            <td>{{$dealer->type}}</td>
                            <td>{{$dealer->email}}</td>
                            <td>{{$dealer->telephone}}</td>
                            <td><input type="radio" name="dealerid" value="{{$dealer->iddealers}}" checked></td>
                        </tr>
                    @endforeach
                    {{csrf_field()}}
                    <input type="hidden" name="invCode" value="{{$invCode}}">
                    <tr>
                        <td colspan="4" align="center">
                            <input type="submit" value="Select" class="btn btn-success" style="width:300px;">
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
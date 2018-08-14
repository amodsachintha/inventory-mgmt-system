<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Edit options</title>
</head>
<body style="padding: 20px">
<div class="container">
    <div class="row">
        <kbd>{{$maincategory}}</kbd>>><kbd>{{$subcategory}}</kbd>
    </div>
    <div class="row" style="border-bottom: 10px; border-top: 10px">
        <div class="text-primary"><h3>{{$itemname}}</h3></div>
    </div>

    <div class="row">
        <form action="/items/init3" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="itemcode" value="{{$itemcode}}">
            <input type="hidden" name="maincategory" value="{{$maincategory}}">
            <input type="hidden" name="subcategory" value="{{$subcategory}}">
            <table class="table table-responsive table-hover">
                <tr>
                    <th>Option</th>
                    <th>Value</th>
                </tr>
                @foreach($optionsTable as $option)
                    <tr>
                        <td>{{$option->name}}</td>
                        <td><input title="{{$option->name}}" type="text" name="{{$option->name}}"></td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Finish" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>
</body>
</html>

<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Edit options</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="text-info">{{$mainCategory}}</div>
            <div><code>{{$subCategory}}</code></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="/subcategory/edit/addnew" method="GET">
                <label>Option name: </label>
                <input type="text" name="option">
                <input type="hidden" name="mainCategory" value="{{$mainCategory}}">
                <input type="hidden" name="subCategory" value="{{$subCategory}}">
                <input type="submit" value="Add">
            </form>
        </div>
    </div>
</div>
</body>
</html>
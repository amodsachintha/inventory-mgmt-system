<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Edit options</title>
</head>
<body style="padding: 20px">
<div class="container">
    <div class="row" align="left">
        <div class="text-primary">{{$mainCategory}} -> {{$subCategory}}</div>
        <code>Edit options</code>
        <table  style="font-family: Avenir, Helvetica, sans-serif; border-color: #f5f8fa; padding: -10px">
            <form action="/subcategory/edit/update" method="GET">
                <input type="hidden" name="mainCategory" value="{{$mainCategory}}">
                <input type="hidden" name="subCategory" value="{{$subCategory}}">
                <?php $i = 0; $printed = false; ?>
                <tr>
                    <td colspan="2" align="left">
                        <mark>select attributes</mark>
                    </td>
                </tr>
                @foreach($subCatOptionsTable as $row)
                    <tr>
                        @foreach($currentOptions as $option)
                            @if($row->name == $option->name && $row->subcategory == $option->subcategory)
                                <td colspan="2" align="left"><input type="checkbox" name="{{$i++}}" value="{{$row->name}}" checked> -<kbd>{{$row->name}} , ({{$row->subcategory}})</kbd></td>
                                <?php $printed=true; ?>
                                @break
                            @endif
                        @endforeach
                        @if($printed == true)
                            <?php $printed = false; ?>
                            @continue
                        @endif
                        <td colspan="2" align="left"><input type="checkbox" name="{{$i++}}" value="{{$row->name}}"> -<kbd>{{$row->name}} , ({{$row->subcategory}})</kbd></td>
                    </tr>
                @endforeach
                <input type="hidden" name="length" value="{{$i}}">
                <tr>
                    <td colspan="2" align="center" style="padding: 10px">
                         <a href="/subcategory/edit/addoption/{{$mainCategory}},{{$subCategory}}">Add new option</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" value="Submit"></td>
                </tr>
            </form>
        </table>
    </div>
</div>


<script type="text/javascript">

    function addBox(n) {
        var div = document.getElementById("addBoxes");
        var input = document.createElement("input");
        input.type = "text";
        input.name = n;
        input.style = "margin-top: 5px";
        input.placeholder = "new attribute";
        div.appendChild(input);
        div.appendChild(document.createElement("br"));
    }

    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }


</script>

</body>
</html>
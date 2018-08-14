<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Item Details</title>
</head>
<body style="padding: 20px">
<script src="{{ asset('js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    tinyMCE.init({
        selector: "textarea.editor",
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify",
        menu: "no",
        theme: "modern"
    });
</script>
<div class="container">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-sm-3">

        </div>
        <div class="col-sm-6" align="center">
            <kbd>{{$maincategory}}</kbd> >> <kbd>{{$subcategory}}</kbd>
            <div class="text-primary"><strong><h3>Add item to inventory</h3></strong></div>
        </div>
        <div class="col-sm-3">

        </div>
    </div>
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <form action="/items/add" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="maincategory" value="{{$maincategory}}">
                <input type="hidden" name="subcategory" value="{{$subcategory}}">
                <div class="form-group">
                    <label for="name">Item name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="subheading">Sub heading:</label>
                    <textarea name="subheading" class="form-control" id="subheading" required></textarea>
                </div>
                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <select name="brand" id="brand" class="form-control" required>
                        @foreach($brandstable as $brand)
                            <option value="{{$brand->brandcode}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" name="price" id="price" class="form-control" onkeypress="validate(event)" required>
                    <label for="discount">Discount:</label>
                    <input type="text" name="discount" id="discount" class="form-control" onkeypress="validate(event)" required>
                </div>
                <div class="form-group">
                    <label for="warranty">Warranty Period:</label>
                    <input type="text" name="warranty" id="warranty" class="form-control" required>
                    <label for="duration">Duration:</label>
                    <select name="duration" class="form-control" id="duration" required>
                        <option value="Years">Years</option>
                        <option value="Months">Months</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="stocklevel">Stock amount</label>
                    <input type="number" id="stocklevel" name="stocklevel" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control editor" rows="7"></textarea>
                </div>
                <div class="form-group" align="center">
                    <label for="productimages">Images</label>
                    <input type="file" name="productimage1" id="productimages" required>
                    <input type="file" name="productimage2" id="productimages" required>
                    <input type="file" name="productimage3" id="productimages">
                    <input type="file" name="productimage4" id="productimages">
                </div>
                <div class="form-group" style="margin-top: 20px">
                    <input type="submit" id="submit" value="Submit" class="form-control btn btn-primary">
                </div>

            </form>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>



<script type="text/javascript">

    window.onunload = refreshParent;

    function refreshParent() {
        window.opener.location.reload();
    }

    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }

</script>

</body>
</html>

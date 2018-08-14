<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>{{$itemcode}}</title>
    <style>
        div {
            #border: solid #9ca2a6 1px;
        }
    </style>

</head>
<body>
<script src="{{ asset('js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    tinyMCE.init({
        selector: "textarea.editor",
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify",
        menu: "no",
        theme: "modern"
    });
</script>

<div class="container" style="margin: 30px;" align="center">
    <div class="row" style="font-family: Verdana, sans-serif">
        <div class="col-md-6">
            <div class="jumbotron-fluid" style="border-bottom: solid #a3b1be 1px;">
                EDIT <h2>{{$itemcode}}</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form action="#" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="itemcode" value="{{$itemcode}}">
                <div class="form-group">
                    <label for="subheading">Subheading</label>
                    <input type="text" name="subheading" id="subheading" class="form-control"
                           value="{{$item->subheading}}" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" required name="price" id="price" class="form-control" value="{{$item->price}}" onkeypress="validate(event)">
                </div>
                <div class="form-group">
                    <label for="discount">Discount</label>
                    <input type="text" required name="discount" id="discount" class="form-control" value="{{$item->discount}}"
                           }} onkeypress="validate(event)">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" required id="description" class="form-control editor" rows="7">
                        {{$item->description}}
                </textarea>
                </div>

                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
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
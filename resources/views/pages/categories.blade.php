@extends('layouts.app')

@section('content')

    <script type="text/javascript">
        function pop(url, name) {
            newwindow = window.open(url, 'name', 'height=700,width=600');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }

        function validate_keys(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[a-zA-Z ]/;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="text-success"><h2><strong>Main Category</strong></h2></div>
                    <?php $i = 1;?>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Main Categories</div>
                                <div class="panel-body">
                                    @foreach($mainCategories as $row)
                                        <a href="/pages/categories?maincategory={{$row->name}}">{{$i++}}. {{$row->name}}</a><br>
                                    @endforeach
                                </div>
                            </div>

                            <form action="/pages/categories/addnew/subcat" method="POST">
                                {{csrf_field()}}
                                <input type="text" name="maincategory" onkeypress="validate_keys(event)" required>
                                <input type="submit" value="Add new!">
                            </form>

                        </div>
            </div>

                <div class="col-md-6">
                    @if(isset($subcategories))
                        <h2>{{$returnCategory}}</h2>
                        <table class="table table-responsive">
                            @foreach($subcategories as $row)
                                <tr>
                                    <td>{{$row->subcategoryname}}</td>
                                    <td><a href="#" onclick="pop('/pages/categories/edit/subcat/{{$returnCategory}},{{$row->subcategoryname}}','{{$row->subcategoryname}}')">edit</a></td>
                                    <td><a href="/pages/categories/delete/subcat/{{$row->subcategoryname}}" onclick="return confirm('Are you sure?')">remove</a></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" align="center">
                                    <?php
                                    echo "<form action='/pages/categories/addnew/subcat' method='get'>
                                        <input type='text' name='name' onkeypress='validate_keys(event)' required>
                                        <input type='hidden' name='mainCat' value='$returnCategory'>
                                        <input type='submit' value='Add new!'>
                                        </form>";
                                    ?>
                                    {{--<td colspan="2" align="center"><a href="#" onclick="return pop('/pages/categories/addsubcat/{{$returnCategory}}','{{$returnCategory}}')">Add--}}
                                </td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
    </div>



@endsection()
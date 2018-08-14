@extends('layouts.app')

@section('content')
    <?php $i = 1; ?>
    <div class="container" xmlns:-webkit-filter="http://www.w3.org/1999/xhtml">
        @if(isset($success))
            <script type="text/javascript">
                function showalert() {
                    return alert('{{$success}}');
                }

                showalert();
            </script>
        @endif
        <div class="row">
            <div class="col-sm-8">
                <div>
                    <h1><strong>Brands</strong></h1>
                    <h5>All brands the items in the inventory belong to, are shown here</h5>
                </div>
            </div>
            <div class="col-sm-4" align="right">
                <div style="margin-top: 50px">
                    <form action="/pages/brands" method="GET">
                        <input type="text" placeholder="Search brands.." name="search">
                        <input type="submit" value="Search" class="btn btn-default">
                    </form>
                </div>
            </div>
        </div>
            @if(isset($searchtext))
                <div class="row" style="margin-top: 10px; margin-bottom: 10px">
                    <div class="col-md-8 col-md-offset-2" align="center">
                        <div class="text-success">Showing results for <strong><i>{{$searchtext}}</i></strong></div>
                    </div>
                </div>
            @endif
        <div class="row">
            <div class="col-md-12">
                <form action="/pages/brands/add" method="POST" enctype="multipart/form-data">
                    <table class="table table-responsive table-hover" style="-webkit-filter: drop-shadow(1px 2px 2px gray)">
                        <tr style="background-color: #e1e1e1; font-family: Avenir, Helvetica, sans-serif">
                            <th>#</th>
                            <th>logo</th>
                            <th>Brand Code</th>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        @if(sizeof($brandsTable) == 0)
                            <tr style="background-color: #ffffff; font-family: Verdana">
                                <td colspan="6" align="center"><p class="text-danger">Sorry! No results!</p></td>
                            </tr>
                        @endif

                        @foreach($brandsTable as $row)
                            <tr style="background-color: #ffffff; font-family: Verdana">
                                <td>{{$i++}}</td>
                                @if(isset($row->brandlogo))
                                    <td><img src="/images/brandlogos/{{$row->brandlogo}}" width="30px"></td>
                                @else
                                    <td>N/A</td>
                                @endif
                                <td><strong>{{$row->brandcode}}</strong></td>
                                <td>{{$row->name}}</td>
                                <td><a href="#" onclick="pop('/pages/brands/showedit/{{$row->brandcode}}','Edit Brand')">edit</a></td>
                                <td><a href="/brand/delete/{{$row->brandcode}}" onclick="return confirm('Are you sure?')">delete</a></td>
                            </tr>
                        @endforeach

                        <tr style="background-color: #eeeeee; font-family: Verdana">
                            {{csrf_field()}}
                            <td>#</td>
                            <td><input type="file" name="brandlogo" required></td>
                            <td><input type="text" name="brandcode" placeholder="brand code" class="form-control" required></td>
                            <td><input type="text" name="brandname" placeholder="brand name" class="form-control" required></td>
                            <td colspan="2"><input type="submit" value="Add new" class="btn btn-success"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="row" align="center">
            {{$brandsTable->links()}}
        </div>
    </div>

@endsection
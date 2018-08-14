<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/images/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                    @else
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Items<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/pages/items">View All</a></li>
                                    <li><a href="#" onclick="pop('/items/init', 'Add item')">Add Item</a></li>
                                    <li><a href="/items/report/inventory" target="_blank">Inventory Report</a></li>
                                </ul>
                            </li>

                            <li><a href="/pages/brands">Brands</a></li>
                            <li><a href="/pages/customers">Customers</a></li>
                            <li><a href="/pages/dealers">Dealers</a></li>
                            <li><a href="/pages/invoice/sales">Invoices</a></li>
                            <li><a href="/pages/categories">Categories</a></li>
                            <li><a href="/pages/cart/sales"><img src="/images/cart.png" width="20px"> <kbd
                                            style="font-size: 12px">{{\App\Http\Controllers\CartController::getCartItemCount1()}}</kbd></a></li>
                            <li><a href="/pages/cart/dealer"><img src="/images/cart.png" width="20px"> <code>{{\App\Http\Controllers\CartController::getCartItemCount2()}}</code></a></li>
                        @endif

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="/images/avatars/{{\App\Http\Controllers\ProfileController::getAvatar()}}" height="25"
                                     style="border-radius: 90px; -webkit-filter: drop-shadow(0px 0px 5px #2e525c);"> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/pages/profile">Profile</a></li>

                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
<script type="text/javascript">
    function pop(url, name) {
        newwindow = window.open(url, 'name', 'height=800,width=700');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }

    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
<script src="{{ asset('js/app.js') }}"></script>


</body>

<div style="margin-top: 70px;" >
<div style="position: fixed; bottom: 0px; background-color: #FFFFFF; width: 100%; height: 50px; margin-top: 10px; border-top: solid 1px #d3e0e9; z-index: 10" align="center">
<p><strong>admin.dreamtech.lk</strong><br>amodsachintha&trade; &copy;{{date('Y')}}</p>
</div>
</div>

{{--<div class="footer" align="center" style="background-color: rgba(209,236,241,0.2); padding-top: 10px; padding-bottom: 20px; border-top: solid #d3d9df 1px;">--}}
    {{--<kbd>&copy; NetAsset&reg;</kbd>--}}
{{--</div>--}}

</html>

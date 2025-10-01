<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vanee Foods - Samples</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/all.js') }}"></script>

    <!-- Favicon -->
    <!--link rel="shortcut icon" href="{{ asset('public/images/favicon.png') }}"-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/samples.css') }}" rel="stylesheet">

    <!-- Bootstrap / Core CSS -->
    <link href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <!--link href="{{ asset('public/css/all.css') }}" rel="stylesheet"-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('public/css/simple-sidebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/global.css') }}" rel="stylesheet" />

    <!-- Other -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <!-- Wrapper -->
    <div class="d-flex toggled" id="wrapper">
        <!-- Page Content Wrapper -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <a href="{{ route('sample-orders') }}" class="navbar-brand">
                    <img src="{{ asset('public/images/logo.png') }}" width="45" class="d-inline-block align-middle" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">

                        @if (!session('authenticated'))
                            <!-- Login -->
                            <li class="nav-item {{ Request::is('/login') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('sample-login') }}">Sign In <span class="sr-only">(current)</span></a>
                            </li>
                        @else
                            <!-- My Orders -->
                            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('sample-orders') }}">My Orders <span class="sr-only">(current)</span></a>
                            </li>

                            @if (!session('address_1'))
                                <!-- Address -->
                                <li class="nav-item {{ Request::is('address') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('sample-address') }}">Create New Order <span class="sr-only">(current)</span></a>
                                </li>
                            @else
                                <!-- Address -->
                                <li class="nav-item {{ Request::is('address') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('sample-address') }}">Change Address <span class="sr-only">(current)</span></a>
                                </li>

                                <!-- Cart -->
                                <li class="nav-item {{ Request::is('cart') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('sample-cart') }}">Cart <span class="sr-only">(current)</span></a>
                                </li>

                                {{--
                                    @if (!session('cart'))
                                        <!-- Cart -->
                                        <li class="nav-item {{ Request::is('cart') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('sample-cart') }}">Cart <span class="sr-only">(current)</span></a>
                                        </li>
                                    @else
                                        <!-- Cart -->
                                        <li class="nav-item {{ Request::is('cart') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('sample-cart') }}">Cart <span class="sr-only">(current)</span></a>
                                        </li>

                                        <!-- Checkout -->
                                        <li class="nav-item {{ Request::is('checkout') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('sample-checkout') }}">Checkout <span class="sr-only">(current)</span></a>
                                        </li>
                                    @endif
                                --}}
                            @endif

                            <!-- Logout -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdowns" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdowns">
                                    <a class="dropdown-item" href="{{ route('sample-logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('sample-logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif

                    </ul>
                </div>
            </nav>

            <div class="container-fluid">
                @yield ('content')
            </div>
        </div>
        <!-- /#page-content-wrapper -->

        <!-- Sidebar Wrapper -->

        @if (session('address_1'))
            <div class="bg-light border-left" id="sidebar-wrapper" style="position: relative;">
                <div id="menu-toggle" style=""><i id="menu-toggle-char" class="fa fa-caret-left"></i></div>
                <!--
                <div class="sidebar-heading mx-1 my-3" style="height: 100px !important; background-size: cover; background-image: url('/public/images/logo.png');"></div>
                -->

                <div class="list-group list-group-flush" style="font-size: 0.8rem;">

                    <div class="list-group-item list-group-item-action" style="padding: 0.75rem; text-align: center;">
                        <a href="/checkout" class="button btn btn-success">Continue to Checkout</a>
                    </div>

                    <div class="list-group-item list-group-item-action" style="padding: 0.75rem;">
                        <address class="mb-0">
                            <strong style="text-decoration: underline;">{{ $data['current_address']['company_name'] }}</strong>
                            <!--<br /><strong>ATTN: {{ $data['current_address']['attn'] }}</strong>-->
                            <!--<br />{{ ($data['current_address']['type'] == "residential") ? "Residential" : "Business" }}-->

                            <br />{{ $data['current_address']['address_1'] }}
                            
                            @if (strlen($data['current_address']['address_2']) > 0)
                                <br />{{ $data['current_address']['address_2'] }}
                            @endif

                            <br />{{ $data['current_address']['city'] }}, {{ $data['current_address']['state'] }}&nbsp;&nbsp;{{ $data['current_address']['zip'] }}

                            <!--
                            @if (isset($data['current_address']['by']))
                                <br />{{ $data['current_address']['by'] }}
                            @endif
                            -->
                        </address>
                    </div>

                    @if (isset($data['order_qty']) && $data['order_qty'] > 0)
                        <div class="list-group-item list-group-item-action" style="padding: 0.75rem; text-align: center;">
                            {{ $data['order_qty'] }} item(s) in shopping cart
                        </div>
                    @endif

                    @if (isset($data['shopping_cart']))
                        <div id="sample-sidebar-items">
                            @forelse ($data['sample_inventory'] as $item)
                                <div data-inventory-id="{{ $item->id }}" class="list-group-item list-group-item-action" style="padding: 0.75rem;">
                                    <div class="show-slideshow" id="inventory-id-{{ $item->id }}" data-inventory-id="{{ $item->id }}">
                                        <a href="#" id="anchor-id-{{ $item->id }}" data-toggle="modal" data-target="#itemModal" onClick="LoadModal({{ $item->id }});" data-href="cart/{{ $item->id }}">
                                            {{ $item->stock_number }} - {{ $item->brand }}
                                            <br />{{ $item->description }}
                                        </a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center cart-quantity-label" data-inventory-id="{{ $item->id }}">
                                        <!--
                                        <input type="text" class="mr-2 cart-input sample-units form-control form-control-text" value="{{ isset($data['cart'][$item->id]) ? $data['cart'][$item->id] : 0 }}" data-inventory-id="{{ $item->id }}" />
                                        -->
                                        <select name="" class="mt-1 cart-input sample-units form-control form-control-select" value="{{ isset($data['cart'][$item->id]) ? $data['cart'][$item->id] : 0 }}" data-inventory-id="{{ $item->id }}">
                                            <option value="0" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 0 ? "selected" : "" }}>0</option>
                                            <option value="1" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 1 ? "selected" : "" }}>1</option>
                                            <option value="2" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 2 ? "selected" : "" }}>2</option>
                                            <option value="3" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 3 ? "selected" : "" }}>3</option>
                                            <option value="4" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 4 ? "selected" : "" }}>4</option>
                                            <option value="5" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 5 ? "selected" : "" }}>5</option>
                                            <option value="6" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 6 ? "selected" : "" }}>6</option>
                                            <option value="7" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 7 ? "selected" : "" }}>7</option>
                                            <option value="8" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 8 ? "selected" : "" }}>8</option>
                                            <option value="9" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 9 ? "selected" : "" }}>9</option>
                                            <option value="10" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 10 ? "selected" : "" }}>10</option>
                                            <option value="11" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 11 ? "selected" : "" }}>11</option>
                                            <option value="12" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 12 ? "selected" : "" }}>12</option>
                                            <option value="13" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 13 ? "selected" : "" }}>13</option>
                                            <option value="14" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 14 ? "selected" : "" }}>14</option>
                                            <option value="15" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 15 ? "selected" : "" }}>15</option>
                                            <option value="16" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 16 ? "selected" : "" }}>16</option>
                                            <option value="17" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 17 ? "selected" : "" }}>17</option>
                                            <option value="18" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 18 ? "selected" : "" }}>18</option>
                                            <option value="19" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 19 ? "selected" : "" }}>19</option>
                                            <option value="20" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 20 ? "selected" : "" }}>20</option>

                                            <option value="21" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 21 ? "selected" : "" }}>21</option>
                                            <option value="22" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 22 ? "selected" : "" }}>22</option>
                                            <option value="23" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 23 ? "selected" : "" }}>23</option>
                                            <option value="24" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 24 ? "selected" : "" }}>24</option>
                                            <option value="25" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 25 ? "selected" : "" }}>25</option>
                                            <option value="26" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 26 ? "selected" : "" }}>26</option>
                                            <option value="27" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 27 ? "selected" : "" }}>27</option>
                                            <option value="28" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 28 ? "selected" : "" }}>28</option>
                                            <option value="29" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 29 ? "selected" : "" }}>29</option>
                                            <option value="30" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 30 ? "selected" : "" }}>30</option>

                                            <option value="31" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 31 ? "selected" : "" }}>31</option>
                                            <option value="32" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 32 ? "selected" : "" }}>32</option>
                                            <option value="33" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 33 ? "selected" : "" }}>33</option>
                                            <option value="34" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 34 ? "selected" : "" }}>34</option>
                                            <option value="35" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 35 ? "selected" : "" }}>35</option>
                                            <option value="36" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 36 ? "selected" : "" }}>36</option>
                                            <option value="37" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 37 ? "selected" : "" }}>37</option>
                                            <option value="38" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 38 ? "selected" : "" }}>38</option>
                                            <option value="39" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 39 ? "selected" : "" }}>39</option>
                                            <option value="40" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 40 ? "selected" : "" }}>40</option>

                                            <option value="41" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 41 ? "selected" : "" }}>41</option>
                                            <option value="42" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 42 ? "selected" : "" }}>42</option>
                                            <option value="43" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 43 ? "selected" : "" }}>43</option>
                                            <option value="44" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 44 ? "selected" : "" }}>44</option>
                                            <option value="45" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 45 ? "selected" : "" }}>45</option>
                                            <option value="46" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 46 ? "selected" : "" }}>46</option>
                                            <option value="47" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 47 ? "selected" : "" }}>47</option>
                                            <option value="48" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 48 ? "selected" : "" }}>48</option>
                                            <option value="49" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 49 ? "selected" : "" }}>49</option>
                                            <option value="50" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 50 ? "selected" : "" }}>50</option>

                                        </select>

                                        <!--
                                        <a href="#" class="btn btn-primary add-to-cart sample-units mt-1" data-inventory-id="{{ $item->id }}">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </a>
                                        -->

                                        <a href="#" class="btn btn-danger trash-can sample-units ml-1 mt-1" data-inventory-id="{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item list-group-item-action" style="padding: 0.75rem; text-align: center;">
                                    No sample units.
                                </div>
                            @endforelse
                        </div>
                        <div id="display-sidebar-items">
                            @forelse ($data['display_inventory'] as $item)
                                <div data-inventory-id="{{ $item->id }}" class="list-group-item list-group-item-action" style="padding: 0.75rem; background-color: rgba(0,0,0,0.05) !important">
                                    <div class="show-slideshow" id="inventory-id-{{ $item->id }}" data-inventory-id="{{ $item->id }}">
                                        <a href="#" id="anchor-id-{{ $item->id }}" data-toggle="modal" data-target="#itemModal" onClick="LoadModal({{ $item->id }});" data-href="cart/{{ $item->id }}">
                                            {{ $item->stock_number }} - {{ $item->brand }}
                                            <br />{{ $item->description }}
                                        </a>
                                    </div>

                                    Display Only:

                                    <div class="d-flex align-items-center justify-content-center cart-quantity-label" data-inventory-id="{{ $item->id }}">
                                        <!--
                                        <input type="text" class="mr-2 cart-input display-units form-control form-control-text" value="{{ isset($data['display'][$item->id]) ? $data['display'][$item->id] : 0 }}" data-inventory-id="{{ $item->id }}" />
                                        -->

                                        <select name="" class="mt-1 cart-input display-units form-control form-control-select" value="{{ isset($data['display'][$item->id]) ? $data['display'][$item->id] : 0 }}" data-inventory-id="{{ $item->id }}">
                                            <option value="0" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 0 ? "selected" : "" }}>0</option>
                                            <option value="1" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 1 ? "selected" : "" }}>1</option>
                                            <option value="2" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 2 ? "selected" : "" }}>2</option>
                                            <option value="3" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 3 ? "selected" : "" }}>3</option>
                                            <option value="4" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 4 ? "selected" : "" }}>4</option>
                                            <option value="5" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 5 ? "selected" : "" }}>5</option>
                                            <option value="6" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 6 ? "selected" : "" }}>6</option>
                                            <option value="7" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 7 ? "selected" : "" }}>7</option>
                                            <option value="8" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 8 ? "selected" : "" }}>8</option>
                                            <option value="9" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 9 ? "selected" : "" }}>9</option>
                                            <option value="10" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 10 ? "selected" : "" }}>10</option>

                                            <option value="11" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 11 ? "selected" : "" }}>11</option>
                                            <option value="12" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 12 ? "selected" : "" }}>12</option>
                                            <option value="13" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 13 ? "selected" : "" }}>13</option>
                                            <option value="14" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 14 ? "selected" : "" }}>14</option>
                                            <option value="15" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 15 ? "selected" : "" }}>15</option>
                                            <option value="16" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 16 ? "selected" : "" }}>16</option>
                                            <option value="17" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 17 ? "selected" : "" }}>17</option>
                                            <option value="18" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 18 ? "selected" : "" }}>18</option>
                                            <option value="19" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 19 ? "selected" : "" }}>19</option>
                                            <option value="20" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 20 ? "selected" : "" }}>20</option>

                                            <option value="21" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 21 ? "selected" : "" }}>21</option>
                                            <option value="22" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 22 ? "selected" : "" }}>22</option>
                                            <option value="23" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 23 ? "selected" : "" }}>23</option>
                                            <option value="24" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 24 ? "selected" : "" }}>24</option>
                                            <option value="25" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 25 ? "selected" : "" }}>25</option>
                                            <option value="26" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 26 ? "selected" : "" }}>26</option>
                                            <option value="27" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 27 ? "selected" : "" }}>27</option>
                                            <option value="28" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 28 ? "selected" : "" }}>28</option>
                                            <option value="29" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 29 ? "selected" : "" }}>29</option>
                                            <option value="30" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 30 ? "selected" : "" }}>30</option>

                                            <option value="31" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 31 ? "selected" : "" }}>31</option>
                                            <option value="32" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 32 ? "selected" : "" }}>32</option>
                                            <option value="33" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 33 ? "selected" : "" }}>33</option>
                                            <option value="34" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 34 ? "selected" : "" }}>34</option>
                                            <option value="35" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 35 ? "selected" : "" }}>35</option>
                                            <option value="36" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 36 ? "selected" : "" }}>36</option>
                                            <option value="37" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 37 ? "selected" : "" }}>37</option>
                                            <option value="38" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 38 ? "selected" : "" }}>38</option>
                                            <option value="39" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 39 ? "selected" : "" }}>39</option>
                                            <option value="40" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 40 ? "selected" : "" }}>40</option>

                                            <option value="41" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 41 ? "selected" : "" }}>41</option>
                                            <option value="42" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 42 ? "selected" : "" }}>42</option>
                                            <option value="43" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 43 ? "selected" : "" }}>43</option>
                                            <option value="44" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 44 ? "selected" : "" }}>44</option>
                                            <option value="45" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 45 ? "selected" : "" }}>45</option>
                                            <option value="46" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 46 ? "selected" : "" }}>46</option>
                                            <option value="47" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 47 ? "selected" : "" }}>47</option>
                                            <option value="48" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 48 ? "selected" : "" }}>48</option>
                                            <option value="49" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 49 ? "selected" : "" }}>49</option>
                                            <option value="50" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 50 ? "selected" : "" }}>50</option>
                                        </select>

                                        <!--
                                        <a href="#" class="btn btn-primary add-to-cart display-units mt-1" data-inventory-id="{{ $item->id }}">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </a>
                                        -->

                                        <a href="#" class="btn btn-danger add-to-cart display-units ml-2 mt-1" data-inventory-id="{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item list-group-item-action" style="padding: 0.75rem; text-align: center;">
                                    No display units.
                                </div>
                            @endforelse
                        </div>
                    @else
                        Contact administrator.
                    @endif

                    <div class="list-group-item list-group-item-action" style="padding: 0.75rem; text-align: center;">
                        <a href="#" onClick="ResetSession();" class="button btn btn-danger btn-sm">EMPTY CART</a>
                    </div>
                    
                </div>
            </div>
        @endif
        <!-- /#sidebar-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Sample Details Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="item-name"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="modal-src" class="embed-responsive-item" src=""></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100 d-flex align-items-center justify-content-between px-3">
                        <div class="d-flex align-items-center">
                            <div class="mr-2">
                                In Cart:
                            </div>
                            <div class="modal-inventory-id cart-quantity-label mr-2" data-inventory-id="">
                                <!--
                                <input type="text" id="modal-qty" class="modal-inventory-id cart-input sample-units form-control form-control-text" value="" data-inventory-id="" />
                                -->

                                <select id="modal-qty" class="modal-inventory-id cart-input sample-units form-control form-control-select" data-inventory-id="">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>

                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>

                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>

                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>

                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div>
                                <!--
                                <a href="#" class="btn btn-primary modal-inventory-id add-to-cart" data-inventory-id="">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                -->

                                <a href="#" class="btn btn-danger trash-can sample-units ml-1" data-inventory-id="">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="mr-2">
                                Display Units Only:
                            </div>
                            <div class="cart-quantity-label modal-inventory-id mr-2" data-inventory-id="">
                                <!--
                                <input type="text" id="modal-display" class="cart-input display-units modal-inventory-id form-control form-control-text" value="" data-inventory-id="" />
                                -->

                                <select id="modal-display" class="modal-inventory-id cart-input display-units form-control form-control-select" data-inventory-id="">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>

                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>

                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>

                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>

                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div>
                                <!--
                                <a href="#" class="btn btn-primary modal-inventory-id add-to-cart display-units" data-inventory-id="">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                                -->

                                <a href="#" class="btn btn-danger trash-can display-units ml-1" data-inventory-id="">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
    <!-- End Sample Details Modal -->

    <!-- JavaScript Assets -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    @yield ('scripts')

    <script>
        function ResetSession() {
            event.preventDefault();
            if (confirm("Are you sure you want to empty your shopping cart?")) {
                document.location = "/resetSession";
            }
        }

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");

            if ($("#menu-toggle-char").hasClass("fa-caret-right")) {
                $("#menu-toggle-char").removeClass("fa-caret-right");
                $("#menu-toggle-char").addClass("fa-caret-left");
            } else {
                $("#menu-toggle-char").removeClass("fa-caret-left");
                $("#menu-toggle-char").addClass("fa-caret-right");
            }
        });

        $(document).ready(function() {
            @if (isset($data['cart']) && isset($data['display']))
                var cart = {!! json_encode($data['cart']) !!};
                var display = {!! json_encode($data['display']) !!};
            @endif

            // Trash Icon: Remove from Cart
            $("body").on("click", ".trash-can", function() {
                let inventoryId = $(this).attr("data-inventory-id");
                let displayUnits = $(this).hasClass("display-units") ? 1 : 0;
                let qty = 0;

                $.post("/cart/modify", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : 0, "displayUnits" : displayUnits }, function (qty) {
                    if (displayUnits) {
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                        $("#modal-display").val(qty);

                        display[inventoryId] = qty;

                        /*
                        if (!$("#display-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                            location.reload();
                        }
                        */
                    } else {
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                        $("#modal-qty").val(qty);

                        cart[inventoryId] = qty;

                        /*
                        if (!$("#sample-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                            location.reload();
                        }*/
                    }

                    location.reload();

                    $("#checkout-btn").show();
                });

                return false;
            });

            // Modify Cart Value
            $("body").on("change", ".cart-input", function() {
                
                let inventoryId = $(this).attr("data-inventory-id");
                let newQty = parseInt($(this).val());
                let displayUnits = $(this).hasClass("display-units") ? 1 : 0;

                $.post("/cart/modify", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : newQty, "displayUnits" : displayUnits }, function (qty) {
                    if (qty !== newQty) {
                        if (displayUnits) {
                            $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                            $("#modal-display").val(qty);

                            display[inventoryId] = qty;

                            if (!$("#display-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                                location.reload();
                            }
                        } else {
                            $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                            $("#modal-qty").val(qty);

                            cart[inventoryId] = qty;

                            if (!$("#sample-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                                location.reload();
                            }
                        }
                    }

                    if (newQty == 0)
                        location.reload();

                    $("#checkout-btn").show();
                });
            });


            
        });
    </script>

    <!-- Menu Toggle Script -->
    <style>
        .show-slideshow {
            font-weight: 400;
            cursor: pointer;
        }

        .demote {
            font-size: smaller;
            color: rgba(0, 0, 0, 0.67);
        }

        .demote h5, .demote h6 {
            font-size: 1rem;
            color: rgba(0, 0, 0, 0.67);
        }
    </style>
</body>
</html>

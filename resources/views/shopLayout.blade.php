<!DOCTYPE html>
<html>
<head>
    <title>Freshcery | Groceries Organic Store</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="assets/fonts/sb-bistro/sb-bistro.css" rel="stylesheet" type="text/css">
    <link href="assets/fonts/font-awesome/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--Ajouté ce stylesheet pour les icons-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" />

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/packages/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/packages/o2system-ui/o2system-ui.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/packages/owl-carousel/owl-carousel.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/packages/cloudzoom/cloudzoom.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/packages/thumbelina/thumbelina.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/packages/bootstrap-touchspin/bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/css/theme.css') }}">
    @livewireStyles
</head>
<body>
    <div class="page-header">
        <!--=============== Navbar ===============-->
        <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-transparent" id="page-navigation">
            <div class="container">
                <!-- Navbar Brand -->
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="">
                </a>

                <!-- Toggle Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarcollapse">
                    <!-- Navbar Menu -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="/shop" class="nav-link">Shop</a>
                        </li>

                        @auth
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-shopping-basket"></i> <span class="badge badge-primary">{{Auth()->user()->products->count()}}</span>
                            </a>
                            <div class="dropdown-menu shopping-cart">
                                <ul>
                                    <li>
                                        <div class="drop-title">Your Cart</div>
                                    </li>
                                    <li>
                                        <div class="shopping-cart-list">
                                            @forelse($products as $product)
                                                <div class="media">
                                                    <img class="d-flex mr-3" src="{{$product->image_path}}" width="60">
                                                    <div class="media-body">
                                                        <h5><a href="javascript:void(0)">{{$product->name}}</a></h5>
                                                        <p class="price">
                                                            <span>{{$product->prix}} DH</span>
                                                        </p>
                                                        <p class="text-muted">Quantity: {{$product->pivot->quantity}}</p>
                                                    </div>
                                                </div>
                                            @empty
                                                <span>No products</span>
                                            @endforelse
                                        </div>
                                    </li>
                                    <li>
                                        
                                        <div class="drop-title d-flex justify-content-between">
                                            <span>Total:</span>
                                            <span class="text-primary">
                                                <strong>
                                                    {{$total}} DH
                                                </strong>
                                            </span>
                                        </div>
                                    </li>
                                    <li class="d-flex justify-content-between pl-3 pr-3 pt-3">
                                        
                                        <a href="/checkout" class="btn btn-primary">Checkout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endauth
                       @if(Route::has('login')) 
                            @auth
                                @if(Auth::user()->utype === 'ADM')
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="avatar-header"><img src="{{asset('assets/img/logo/avatar.jpg')}}"></div> My Account ({{Auth::user()->name}}) </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        
                                        <a class="dropdown-item" href="{{ url('user/profile') }}">Settings</a> 
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a> 
                                       
										
                                        <form id="logout-form" method="POST" action="{{route('logout')}}"> 
                                        @csrf 
                                        </form> 
                                    </div>
                                    </li>
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <div class="avatar-header"><img src="{{asset('assets/img/logo/avatar.jpg')}}"></div> My Account ({{Auth::user()->name}}) </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            
                                            <a class="dropdown-item" href="{{ url('/user/profile') }}">Settings</a>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a> 
                                             
                                            <form id="logout-form" method="POST" action="{{route('logout')}}"> 
                                            @csrf 
                                            </form> 
                                        </div>
                                        </li>
                                @endif

                            @else

                                <li class="nav-item">
                                <a href="{{route('register') }}" class="nav-link">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('login')}}" class="nav-link">Login</a>
                                </li>
                            @endif

                       @endif
                    </ul>
                </div>

            </div>
        </nav>
    </div>

    <livewire:shop-component/> 

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>About</h5>
                    <p>What is FRESHCERY ? FRESHCERY is an online platform to buy your house products, groceries, etc.
                       Where does it come from? FRESHCERY is stable in Tangier, Morrocco.</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul>
                        <li>
                            <a href="/about">About</a>
                        </li>
                        <li>
                            <a href="/contact-us">Contact Us</a>
                        </li>
                        <li>
                            <a href="/faq">FAQ</a>
                        </li>
                        
                        <li>
                            <a href="/terms">Terms</a>
                        </li>
                        <li>
                            <a href="/privacy">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                     <h5>Contact</h5>
                     <ul>
                         <li>
                            <a href="tel:+620892738334"><i class="fa fa-phone"></i> 08272367238</a>
                        </li>
                        <li>
                            <a href="mailto:hello@domain.com"><i class="fa fa-envelope"></i> hello@domain.com</a>
                         </li>
                     </ul>

                     <h5>Follow Us</h5>
                     <ul class="social">
                         <li>
                            <a href="javascript:void(0)" target="_blank"><i class="fab fa-facebook-f"></i></a>
                         </li>
                         <li>
                            <a href="javascript:void(0)" target="_blank"><i class="fab fa-instagram"></i></a>
                         </li>
                         <li>
                            <a href="javascript:void(0)" target="_blank"><i class="fab fa-youtube"></i></a>
                         </li>
                     </ul>
                </div>
                <div class="col-md-3">
                     <h5>Get Our App</h5>
                     <ul class="mb-0">
                         <li class="download-app">
                             <a href="#"><img src="{{asset('assets/img/playstore.png')}}"></a>
                         </li>
                         <li style="height: 200px">
                             <div class="mockup">
                                 <img src="{{asset('assets/img/mockup.png')}}">
                             </div>
                         </li>
                     </ul>
                </div>
            </div>
        </div>
        <p class="copyright">&copy; 2023 Freshcery | Groceries Organic Store. All rights reserved.</p>
    </footer>

    <script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-migrate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/packages/bootstrap/libraries/popper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/packages/bootstrap/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/packages/o2system-ui/o2system-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/packages/owl-carousel/owl-carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/packages/cloudzoom/cloudzoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/packages/thumbelina/thumbelina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/packages/bootstrap-touchspin/bootstrap-touchspin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/theme.js') }}"></script>
    @livewireStyles
</body>
</html>

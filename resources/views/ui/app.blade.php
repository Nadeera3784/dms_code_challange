<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="bookshop">
        <meta name="keywords" content="">
        <title>{{ isset($title) ? $title . ' | ' : '' }} {{ config('app.name') }}</title>
        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css"/>
        @yield('css')
    </head>
    <body>

        <header class="section-header">
            <nav class="navbar navbar-main navbar-expand-lg navbar-light">
            <div class="container">
              <a class="navbar-brand" href="{{url('/')}}"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></a>
              <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#main_nav2" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="navbar-collapse collapse" id="main_nav2" style="">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{url('/')}}"> Home </a></li>
                <li class="nav-item"><a class="nav-link" href="#"> About </a></li>
                <li class="nav-item"><a class="nav-link" href="#"> Contact </a></li>
              </ul>
              <a href="{{route('cart')}}" class="ml-md-3 btn btn-primary">My cart 
                    <?php $total = 0 ?>
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            <?php $total += $details['price'] * $details['quantity'] ?>
                           
                        @endforeach
                         {{'$'.number_format($total, 2)}}
                    @else
                        {{'$'.number_format(00, 2)}}
                    @endif
              </a>
              </div>
            </div> 
            </nav>
        </header>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="section-footer border-top">
            <div class="container">
                <section class="footer-top padding-y">
                    <div class="row">
                        <aside class="col-md-4">
                            <article class="mr-3">
                                <img src="{{ asset('assets/images/logo.png') }}" class="logo-footer">
                                <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad </p>
                                <div>
                                    <a class="btn btn-icon btn-light" title="Facebook" target="_blank" href="#"><i class="mdi mdi-facebook"></i></a>
                                    <a class="btn btn-icon btn-light" title="Instagram" target="_blank" href="#"><i class="mdi mdi-instagram"></i></a>
                                    <a class="btn btn-icon btn-light" title="Youtube" target="_blank" href="#"><i class="mdi mdi-youtube"></i></a>
                                    <a class="btn btn-icon btn-light" title="Twitter" target="_blank" href="#"><i class="mdi mdi-twitter"></i></a>
                                </div>
                            </article>
                        </aside>
                        <aside class="col-sm-3 col-md-2">
                            <h6 class="title">About</h6>
                            <ul class="list-unstyled">
                                <li> <a href="#">About us</a></li>
                                <li> <a href="#">Services</a></li>
                                <li> <a href="#">Rules and terms</a></li>
                                <li> <a href="#">Blogs</a></li>
                            </ul>
                        </aside>
                        <aside class="col-sm-3 col-md-2">
                            <h6 class="title">Services</h6>
                            <ul class="list-unstyled">
                                <li> <a href="#">Help center</a></li>
                                <li> <a href="#">Money refund</a></li>
                                <li> <a href="#">Terms and Policy</a></li>
                                <li> <a href="#">Open dispute</a></li>
                            </ul>
                        </aside>
                        <aside class="col-sm-3  col-md-2">
                            <h6 class="title">For users</h6>
                            <ul class="list-unstyled">
                                <li> <a href="#"> User Login </a></li>
                                <li> <a href="#"> User register </a></li>
                                <li> <a href="#"> Account Setting </a></li>
                                <li> <a href="#"> My Orders </a></li>
                                <li> <a href="#"> My Wishlist </a></li>
                            </ul>
                        </aside>
                        <aside class="col-sm-2  col-md-2">
                            <h6 class="title">Our app</h6>
                            <a href="#" class="d-block mb-2"><img src="{{ asset('assets/images/appstore.png') }}" height="40"></a>
                            <a href="#" class="d-block mb-2"><img src="{{ asset('assets/images/playmarket.png') }}" height="40"></a>
                        </aside>
                    </div>
                </section> 

                <section class="footer-copyright border-top">
                        <p target="_blank" class="float-right text-muted">
                            <a href="#">Privacy &amp; Cookies</a> &nbsp;   &nbsp; 
                            <a href="#">Accessibility</a>
                        </p>
                        <p class="text-muted"> © 2021 Bookshop  All rights resetved </p>
                        
                </section>
            </div>
        </footer>

        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/popper.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
        <script type="text/javascript">
          AppHelper = {};
          AppHelper.baseUrl = "{{ url('/') }}";
        </script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        @yield('js')
    </body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('page-title') </title>

    <!-- Font & Icon -->    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('mimity-retail/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('mimity-retail/img/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('mimity-retail/img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('mimity-retail/img/favicon/touch-icon-iphone.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('mimity-retail/img/favicon/touch-icon-ipad.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mimity-retail/img/favicon/touch-icon-iphone-retina.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('mimity-retail/img/favicon/touch-icon-ipad-retina.png') }}">    
        
    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('mimity-retail/plugins/swiper/swiper.min.css') }}">

    <!-- Main style -->
    <link rel="stylesheet" href="{{ asset('mimity-retail/dist/css/style.min.css') }}">

	  @yield('styles')

</head>

<body>

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="container-fluid d-flex align-items-center">

          <nav class="nav mr-1 d-none d-md-flex">
              <a class="nav-link nav-link-sm has-icon pl-0 text-white" href="https://api.whatsapp.com/send?phone={{ $empresa->regtel }}" target="_blank"><i class="material-icons mr-1">phone</i> {{ $empresa->regexttel }} </a>
              <a class="nav-link nav-link-sm has-icon text-white" href="mailto:{{ $empresa->regemail }}"><i class="material-icons mr-1">mail_outline</i> {{ $empresa->regemail }} </a>
          </nav>

          <nav class="nav nav-circle d-none d-sm-flex">
              <a class="nav-link nav-link-sm nav-icon p-0" href="https://www.facebook.com/DiconsaMX" target="_blank"><i class="custom-icon" data-icon="facebook" data-size="17x17"></i></a>
          </nav>

          <div class="btn-group btn-group-toggle btn-group-sm ml-auto mr-1" data-toggle="buttons" hidden>
            &nbsp;
          </div>
          
          <nav class="nav nav-gap-x-1 ml-auto mr-1">
            &nbsp;
          </nav>

            @if(Session::has('almcnt'))
            <a href="{{ route('logoutSession') }}" class="btn btn-faded-primary has-icon btn-sm text-white">
                <i class="material-icons mr-1">exit_to_app</i> Salir
            </a>
            @else
            <button type="button" data-toggle="modal" data-target="#signinModal" class="btn btn-faded-primary text-white has-icon btn-sm">
                <i class="material-icons mr-1">person</i> iniciar sesion
            </button>            
            @endif
                
        </div>
    </div>
    <!-- /TOP BAR -->

    <!-- HEADER -->
    <header>
        <div class="container-fluid">

          <nav class="nav nav-circle d-flex d-lg-none">
              <a href="#menuModal" data-toggle="modal" class="nav-link nav-icon"><i class="material-icons">menu</i></a>
          </nav>

          <nav class="nav ml-3 ml-lg-0">
              <a href="{{ route('webpages.home') }}" class="nav-link has-icon p-0 bg-white">
              <img src="{{ asset('mimity-retail/img/logoTdaBienestar.png') }}" alt="Logo" height="40">
              </a>
          </nav>

          <nav class="nav nav-main nav-gap-x-1 nav-pills ml-3 d-none d-lg-flex">
              <div class="nav-item dropdown dropdown-hover">
                <a class="nav-link dropdown-toggle no-caret forwardable" href="{{ route('webpages.home') }}" id="homeDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tienda
                </a>
              </div>

              <div class="nav-item dropdown dropdown-hover">
                <a class="nav-link dropdown-toggle no-caret forwardable" href="{{ route('webpages.categories') }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categorias
                </a>
              </div>              
          </nav>

          <nav class="nav nav-circle nav-gap-x-1 ml-auto">
              <a class="nav-link nav-icon" data-toggle="modal" href="#searchModal">
              <i class="material-icons">search</i>
              </a>
          </nav>

        </div>
    </header>
    <!-- /HEADER -->

    @yield('content-area')

    <!-- FOOTER -->
    <div class="footer">
        <div class="container-fluid">
        <div class="d-grid grid-template-col-sm-2 grid-template-col-lg-4">
            <div class="px-3 text-center">
            <h5> &nbsp; </h5>
            <p> &nbsp; <strong class="text-primary"> &nbsp; </strong></p>
            <form>
                &nbsp;
            </form>
            </div>
            <div>
            <h5>Contacto</h5>
            <div class="list-group list-group-flush list-group-no-border list-group-sm">
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">correo: {{ $empresa->regemail }}</a>
                <a href="javascript:void(0)" class="list-group-item list-group-item-action">Extensi&oacute;n: {{ $empresa->regexttel }}</a>
            </div>
            </div>
            <div>
            <h5>P&aacute;ginas</h5>
            <div class="list-group list-group-flush list-group-no-border list-group-sm">
                <a href="{{ route('webpages.home') }}" class="list-group-item list-group-item-action">inicio</a>
                <a href="{{ route('webpages.categories') }}" class="list-group-item list-group-item-action">categorias</a>
                <a href="#" class="list-group-item list-group-item-action">contacto</a>
            </div>
            </div>
            <div>
            <h5>Descargar </h5>
            <a href="{{ route('catalogo.download.pdf', ['almcnt' =>$empresa->id ]) }}" target="_blank" class="download-app bg-white">
                <div class="media">
                  <img src="{{ asset('mimity-retail/img/app/products.png') }}" alt="Descargar catalogo" height="30">
                  <div class="media-body">
                      <small>Cat&aacute;logo digital PDF</small>
                      <h5>{{ $empresa->regnom }}</h5>
                  </div>
                </div>
            </a>

            </div>
        </div>
        </div>
    </div>

    <div class="copyright text-white"> <small> inventario perteneciente al {{ $empresa->regnom }} / U.O. {{ $empresa->regmun }} / SUC. {{ $empresa->regedo }} </small>  </div>
    <!-- /FOOTER -->    

    <!-- SIGN-IN MODAL -->
    <div class="modal fade modal-content-right" id="signinModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">

        <div class="modal-content" id="signinContent">
            <div class="modal-header pb-0">
            <div>
                <h3 class="modal-title">Sign in</h3>
                <em>to your account</em>
            </div>
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                <i class="material-icons">close</i>
            </button>
            </div>
            <div class="modal-body">
            <form id="formSignin">
                <div class="form-group">
                <span class="input-icon">
                    <i class="material-icons">mail_outline</i>
                    <input type="email" class="form-control" id="signInEmailInput" placeholder="Email address" required>
                </span>
                </div>
                <div class="form-group">
                <span class="input-icon">
                    <i class="material-icons">lock_open</i>
                    <input type="password" class="form-control" id="signInPasswordInput" placeholder="Password" required>
                </span>
                </div>
                <div class="form-group d-flex justify-content-between">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="rememberCheck" checked>
                    <label class="custom-control-label" for="rememberCheck">Remember me</label>
                </div>
                <u><a href="#" class="text-primary small" id="showResetContent">Forgot password ?</a></u>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>
            <hr>
            <p class="font-italic">Don't have an account ? <u><a href="#" id="showSignupContent">Sign Up</a></u></p>
            <hr>
            <div class="text-center">
                <p class="font-italic">Or sign in via</p>
                <button class="btn btn-icon btn-faded-primary rounded-circle" data-toggle="tooltip" title="Facebook" data-container="#signinContent">
                <i class="custom-icon" data-icon="facebook" data-size="20x20"></i>
                </button>
                <button class="btn btn-icon btn-faded-info rounded-circle" data-toggle="tooltip" title="Twitter" data-container="#signinContent">
                <i class="custom-icon" data-icon="twitter" data-size="20x20"></i>
                </button>
                <button class="btn btn-icon btn-faded-danger rounded-circle" data-toggle="tooltip" title="Google" data-container="#signinContent">
                <i class="custom-icon" data-icon="gplus" data-size="20x20"></i>
                </button>
            </div>
            </div>
        </div>

        <div class="modal-content" id="signupContent" hidden>
            <div class="modal-header pb-0">
            <div>
                <h3 class="modal-title">Sign up</h3>
                <em>create an account</em>
            </div>
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                <i class="material-icons">close</i>
            </button>
            </div>
            <div class="modal-body">
            <form id="formSignup">
                <div class="form-group">
                <input type="text" class="form-control" id="signUpNameInput" placeholder="Full name" required>
                </div>
                <div class="form-group">
                <input type="email" class="form-control" id="signUpEmailInput" placeholder="Email address" required>
                </div>
                <div class="form-group">
                <input type="password" class="form-control" id="signUpPasswordInput" placeholder="Password" required>
                </div>
                <div class="form-group">
                <input type="password" class="form-control" id="signUpPasswordConfirmInput" placeholder="Confirm password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            </form>
            <hr>
            <button class="btn btn-faded-light has-icon btn-sm showSigninContent" type="button">
                <i class="material-icons">chevron_left</i> Back to sign in
            </button>
            </div>
        </div>

        <div class="modal-content" id="resetContent" hidden>
            <div class="modal-header pb-0">
            <div>
                <h3 class="modal-title">Reset Password</h3>
                <em>enter your email address</em>
            </div>
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                <i class="material-icons">close</i>
            </button>
            </div>
            <div class="modal-body">
            <form id="formReset">
                <div class="form-group">
                <span class="input-icon">
                    <i class="material-icons">mail_outline</i>
                    <input type="email" class="form-control" id="resetEmailInput" placeholder="Email address" required>
                </span>
                </div>
                <button type="submit" class="btn btn-danger btn-block">RESET</button>
            </form>
            <hr>
            <button class="btn btn-faded-light has-icon btn-sm showSigninContent" type="button">
                <i class="material-icons">chevron_left</i> Back to sign in
            </button>
            </div>
        </div>

        <div class="modal-content" id="resetDoneContent" hidden>
            <div class="modal-header pb-0 justify-content-end">
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                <i class="material-icons">close</i>
            </button>
            </div>
            <div class="modal-body text-center pt-0">
            <i class="material-icons text-primary display-4">check_circle_outline</i>
            <h3>CHECK YOUR EMAIL</h3>
            <p>We just sent you a letter with instructions to reset your password</p>
            <button class="btn btn-primary btn-block showSigninContent" type="button">Sign in</button>
            </div>
        </div>

        </div>
    </div>
    <!-- /SIGN-IN MODAL -->

    <!-- MENU MODAL -->
    <div class="modal fade modal-content-left" id="menuModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom shadow-sm z-index-1">
            <a href="#"><img src="../../img/logo.png" alt="Logo" height="40"></a>
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                <i class="material-icons">close</i>
            </button>
            </div>
            <div class="modal-body px-0 scrollbar-width-thin">
            <ul class="menu" id="menu">
                <li class="no-sub"><a href="index.html"><i class="material-icons">home</i> Home</a></li>
                <li class="no-sub mm-active"><a href="index2.html"><i class="material-icons">home_work</i> Home layout 2</a></li>
                <li class="no-sub"><a href="index3.html"><i class="material-icons">phonelink</i> Electronics Store</a></li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">shopping_cart</i> Shop</a>
                <ul>
                    <li><a href="shop-categories.html">Shop Categories</a></li>
                    <li><a href="shop-grid.html">Shop Grid</a></li>
                    <li><a href="shop-list.html">Shop List</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li>
                    <a href="#" class="has-arrow">Checkout</a>
                    <ul>
                        <li><a href="checkout-shipping.html">Checkout Shipping</a></li>
                        <li><a href="checkout-payment.html">Checkout Payment</a></li>
                        <li><a href="checkout-review.html">Checkout Review</a></li>
                        <li><a href="checkout-complete.html">Checkout Complete</a></li>
                    </ul>
                    </li>
                    <li><a href="shop-single.html">Single Product</a></li>
                </ul>
                </li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">person</i> Account</a>
                <ul>
                    <li><a href="account-signin.html">Sign In / Sign Up</a></li>
                    <li><a href="account-profile.html">Profile Page</a></li>
                    <li><a href="account-orders.html">Orders List</a></li>
                    <li><a href="account-order-detail.html">Order Detail</a></li>
                    <li><a href="account-wishlist.html" class="has-badge">Wishlist <span class="badge badge-primary badge-pill">3</span></a></li>
                    <li><a href="account-address.html">Address</a></li>
                </ul>
                </li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">rss_feed</i> Blog</a>
                <ul>
                    <li><a href="blog-grid.html">Post Grid</a></li>
                    <li><a href="blog-list.html">Post List</a></li>
                    <li><a href="blog-single.html">Single Post</a></li>
                </ul>
                </li>
                <li>
                <a href="#" class="has-arrow"><i class="material-icons">file_copy</i> Pages</a>
                <ul>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="compare.html">Compare</a></li>
                    <li><a href="faq.html">Help / FAQ</a></li>
                    <li><a href="404.html">404 Not Found</a></li>
                </ul>
                </li>
                <li class="no-sub"><a href="components.html"><i class="material-icons">check_box_outline_blank</i> Components</a></li>
            </ul>
            </div>
        </div>
        </div>
    </div>
    <!-- /MENU MODAL -->

    <!-- SEARCH MODAL -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-1 p-lg-3">
                    <!-- Formulario que envía los datos al método productSearch -->
                    <form action="{{ route('webpages.search') }}" method="get">
                        <div class="input-group input-group-lg input-group-search">
                            <div class="input-group-prepend">
                                <button class="btn btn-text-secondary btn-icon btn-lg rounded-circle" type="button" data-dismiss="modal">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </div>
                            <!-- Campo de búsqueda -->
                            <input type="search" class="form-control form-control-lg border-0 shadow-none mx-1 px-0 px-lg-3" id="searchInput" name="string" placeholder="Buscar clave o descripci&oacute;n" required>
                            <div class="input-group-append">
                                <button class="btn btn-text-secondary btn-icon btn-lg rounded-circle" type="submit">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /SEARCH MODAL -->

    <!-- CART MODAL -->
    <div class="modal fade modal-content-right modal-cart" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
            <h5 class="modal-title" id="cartModalLabel">You have 4 items in your cart</h5>
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                <i class="material-icons">close</i>
            </button>
            </div>
            <div class="modal-body scrollbar-width-thin">
            <ul class="list-group list-group-flush">
                <li class="list-group-item px-0">
                <div class="media">
                    <a href="#" class="mr-2"><img src="#" width="50" height="50" alt="articulo"></a>
                    <div class="media-body">
                    <a href="#" class="d-block text-body" title="articulo">articulo</a>
                    <em class="text-muted">1 x $18.56</em>
                    </div>
                    <button class="btn btn-icon btn-sm btn-text-danger rounded-circle" type="button"><i class="material-icons">close</i></button>
                </div>
                </li>

            </ul>

            </div>
            <div class="modal-footer border-top">
            <div class="mr-auto">
                <em>Subtotal</em>
                <h5 class="mb-0 text-dark font-weight-bold font-condensed">$152.04</h5>
            </div>
            <a href="cart.html" class="btn btn-faded-success">View Cart</a>
            <a href="shipping.html" class="btn btn-success">Checkout</a>
            </div>
        </div>
        </div>
    </div>
    <!-- /CART MODAL -->

    <!-- Main script -->
    <script src="{{ asset('mimity-retail/dist/js/script.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('mimity-retail/plugins/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('mimity-retail/plugins/jquery-countdown/jquery.countdown.min.js') }}"></script>
    
    <!-- Application script -->
    <script src="{{ asset('mimity-retail/dist/js/app.min.js') }}"></script>
    <script>
      $(() => {
  
        App.atcDemo() // Add to Cart Demo
        App.atwDemo() // Add to Wishlist Demo
        App.homeSlider('#homeSlider')
        App.dealSlider2('#dealSlider2')
        App.brandSlider('#brandSlider')
        App.colorOption()
  
  
      })
    </script>

    @yield('scripts')

    @yield('modal')

</body>
</html>


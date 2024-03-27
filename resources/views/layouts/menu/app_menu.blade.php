
@auth
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
        aria-expanded="false">
        {{ __('Profile') }}
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('profile.orders') }}">{{ __('Orders') }}</a>
            

    </div>
</li>
  
@endauth

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
        aria-expanded="false">
        {{ __('Languages') }}
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="/lenguaje/es">{{ __('Spanish') }}</a>
        <a class="dropdown-item" href="/lenguaje/en">{{ __('English') }}</a>
            

    </div>
</li>
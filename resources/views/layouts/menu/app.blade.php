<li class="nav-item active">
    <a class="nav-link" href="#">{{ __('Home') }} </a>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
        aria-expanded="false">
        {{ __('Categories') }}
    </a>
    <div class="dropdown-menu">
        @foreach (categories() as $row)
        <a class="dropdown-item" href="/categorias/{{ $row->slug }}">{{ $row->name }}</a>
            
        @endforeach

    </div>
</li>
@auth
<li class="nav-item ">
    <a class="nav-link" href="{{ route('shopping_cart') }}">{{ __('Shopping Cart') }} </a>
</li>
@endauth
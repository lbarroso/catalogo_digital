<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    
    <li class="nav-item ">
        <a href="{{ route('admin.home') }}" class="nav-link {{ active_menu(route('admin.home')) }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link  {{ active_menu(route('admin.users.index')) }}">
            <i class="nav-icon far fa-user"></i>
            <p>
                Usuarios
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ active_menu(route('admin.categories.index')) }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Categorias
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ active_menu(route('admin.products.index')) }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Productos
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ active_menu(route('admin.orders.index')) }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Pedidos
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="pages/gallery.html" class="nav-link">
            <i class="nav-icon far fa-envelope"></i>
            <p>
                Mensajes
            </p>
        </a>
    </li>
    <li class="nav-item {{ menu_open('administracion/examples/*',1) }}">
        <a href="#" class="nav-link {{ menu_open('administracion/examples/*',2) }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Ejercicios
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.figures.index') }}" class="nav-link {{ active_menu(route('admin.figures.index')) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Figuras</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.projects.index') }}" class="nav-link {{ active_menu(route('admin.projects.index')) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Proyectos</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.persons.index') }}" class="nav-link {{ active_menu(route('admin.persons.index')) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Persona</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.posts.index') }}" class="nav-link {{ active_menu(route('admin.posts.index') ) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Post</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.animals.index') }}" class="nav-link {{ active_menu(route('admin.animals.index') ) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Animales</p>
                </a>
            </li>
           
        </ul>
    </li>
   
</ul>

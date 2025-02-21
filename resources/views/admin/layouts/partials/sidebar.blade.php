<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('libs/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
    </div>
</div>

<!-- SidebarSearch Form -->
<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard v1</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-pie nav-icon"></i>
                        <p>Charts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Forms</p>
                    </a>
                </li>

            </ul>
        </li>
        {{-- User --}}
        @if (Auth::guard('admin')->check())
            <li class="nav-item">
                <a href=" #" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        User
                        <i class="fas fa-angle-left right"></i>
                        {{-- <span class="badge badge-info right">6</span> --}}
                        {{-- <span class="right badge badge-danger">New</span> --}}
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route(getRouteName('users.index')) }}" class="nav-link ">
                            <i class="fas fa-portrait nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route(getRouteName('users.create')) }}" class="nav-link ">
                            <i class="fas fa-user-plus nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-edit nav-icon"></i>
                        <p>Edit</p>
                    </a>
                </li> --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users-slash nav-icon"></i>
                            <p>Banned</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        {{-- End User --}}

        {{-- Product --}}
        <li class="nav-header"></li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-boxes"></i>
                <p>
                    Products
                    <i class="fas fa-angle-left right"></i>
                    {{-- <span class="badge badge-info right">6</span> --}}
                    {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route(getRouteName('products.index')) }}" class="nav-link ">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route(getRouteName('products.create')) }}" class="nav-link ">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>Create</p>
                    </a>
                </li>
                {{--                 
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-edit nav-icon"></i>
                        <p>Edit</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users-slash nav-icon"></i>
                        <p>Banned</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- End Product --}}
        {{-- Category --}}
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th-large"></i>
                <p>
                    Categories
                    <i class="fas fa-angle-left right"></i>
                    {{-- <span class="badge badge-info right">6</span> --}}
                    {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route(getRouteName('categories.index')) }}" class="nav-link ">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route(getRouteName('categories.create')) }}" class="nav-link ">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>Create</p>
                    </a>
                </li>
                {{--       
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-edit nav-icon"></i>
                        <p>Edit</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users-slash nav-icon"></i>
                        <p>Banned</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- End Category --}}
        {{-- Order --}}
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-basket"></i>
                <p>
                    Orders
                    <i class="fas fa-angle-left right"></i>
                    {{-- <span class="badge badge-info right">6</span> --}}
                    {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>Create</p>
                    </a>
                </li>
                {{--       
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-edit nav-icon"></i>
                        <p>Edit</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users-slash nav-icon"></i>
                        <p>Banned</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- End Order --}}
    </ul>
</nav>
<!-- /.sidebar-menu -->

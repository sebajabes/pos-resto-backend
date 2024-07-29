<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">POS RESTO SEBAJ</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">PRS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('home') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('home') }}">Dashboard</a>
                    </li>
                    <li class=''>
                        <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class=''>
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class=''>
                        <a class="nav-link" href="{{ route('categories.index') }}">Category</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>

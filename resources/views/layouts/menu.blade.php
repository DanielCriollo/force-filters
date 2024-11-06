<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Force Filters</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Escritorio</div>
            </a>
        </li>

        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Clientes</span></li>

        <li class="menu-item {{ Request::routeIs('customers') ? 'active' : '' }}">
            <a href="{{ route('customers') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Clientes</div>
            </a>
        </li> 

        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Ventas</span></li>


        <li class="menu-item {{ Request::routeIs('sales-products') ? 'active' : '' }}">
            <a href="{{ route('sales-products') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Nueva Venta</div>
            </a>
        </li> 
        <li class="menu-item {{ Request::routeIs('sales') ? 'active' : '' }}">
            <a href="{{ route('sales') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Ventas</div>
            </a>
        </li> 
    
        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Productos</span></li>

        <li class="menu-item {{ Request::routeIs('products') ? 'active' : '' }}">
            <a href="{{ route('products') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Productos</div>
            </a>
        </li> 
        <li class="menu-item {{ Request::routeIs('brands') ? 'active' : '' }}">
            <a href="{{ route('brands') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Marcas</div>
            </a>
        </li> 

        <li class="menu-item {{ Request::routeIs('product-types') ? 'active' : '' }}">
            <a href="{{ route('product-types') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Tipos</div>
            </a>
        </li> 
        <li class="menu-item {{ Request::routeIs('product-categories') ? 'active' : '' }}">
            <a href="{{ route('product-categories') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Categorias</div>
            </a>
        </li> 
    </ul>
</aside>

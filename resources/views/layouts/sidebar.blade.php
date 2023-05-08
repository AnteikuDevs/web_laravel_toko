<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (auth()->user()->role == '1')
        
        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'dashboard'? 'active' : 'collapsed' }}" href="{{ route('admin.dashboard.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'category'? 'active' : 'collapsed' }}" href="{{ route('admin.category.index') }}">
                <i class="bi bi-menu-button-wide"></i><span>Kategori</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'product'? 'active' : 'collapsed' }}" href="{{ route('admin.product.index') }}">
                <i class="bi bi-box"></i><span>Produk</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'transaction'? 'active' : 'collapsed' }}" href="{{ route('admin.transaction.index') }}">
                <i class="bi bi-card-list"></i><span>Transaksi</span>
            </a>
        </li>

        @elseif (auth()->user()->role == '2')
        
        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'dashboard'? 'active' : 'collapsed' }}" href="{{ route('kasir.dashboard.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::segment(2) == 'transaction'? 'active' : 'collapsed' }}" href="{{ route('kasir.transaction.index') }}">
                <i class="bi bi-card-list"></i><span>Transaksi</span>
            </a>
        </li>

        @endif

    </ul>

</aside><!-- End Sidebar-->

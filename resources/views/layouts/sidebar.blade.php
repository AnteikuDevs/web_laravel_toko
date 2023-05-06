<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (auth()->user()->role == '1')
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.dashboard.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-menu-button-wide"></i><span>Kategori</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Produk</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-file"></i><span>Transaksi</span>
            </a>
        </li>

        @endif

    </ul>

</aside><!-- End Sidebar-->

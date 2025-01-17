<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img class="img-fluid" src="{{ asset('img/logo/full.png') }}" alt="logo" width="200px">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item @if (url()->full() == route('dashboard')) active @endif">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <li class="menu-item @if (url()->full() == route('order.index')) active @endif">
            <a href="{{ route('order.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-check"></i>
                <div class="text-truncate">Riwayat Transaksi</div>
            </a>
        </li>

        @hasanyrole(['admin'])
            <li class="menu-item @if (url()->full() == route('book.index')) active @endif">
                <a href="{{ route('book.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div class="text-truncate">Buku</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengguna</span>
            </li>
            <li class="menu-item @if (url()->full() == route('customer.index')) active @endif">
                <a href="{{ route('customer.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div class="text-truncate">Customer</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-check"></i>
                    <div class="text-truncate">Admin</div>
                </a>
            </li>
        @endhasanyrole

        <!-- Misc -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
        <li class="menu-item">
            <a href="https://github.com/riezq25/simple-store" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div class="text-truncate">Repository</div>
            </a>
        </li>
    </ul>
</aside>

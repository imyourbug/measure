<nav class="main-header navbar navbar-expand navbar-white navbar-light tutorial">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ Auth::user()?->role == 1 ? route('admin.index') : route('users.home') }}" class="nav-link">TRANG
                CHỦ</a>
        </li>

        @if (Auth::user()?->role == 1)
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    DANH MỤC
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: inherit; right: 0px;">
                    <p class="dropdown-item" style="font-weight: bold;">DANH SÁCH NHIỆM VỤ</p>
                    @foreach ($types as $type)
                        <a class="dropdown-item" href="{{ route('admin.tasks.index') }}" style="font-weight:bold;">
                            {{ $type->name }}
                        </a>
                        @foreach ($type->children as $child)
                            <a href="{{ route('admin.tasks.index') }}" style="padding-left: 40px" class="dropdown-item">
                                -&emsp;{{ $child->name }}
                            </a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                    @endforeach
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    NGHIỆP VỤ
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: inherit; right: 0px;">
                    <p class="dropdown-item" style="font-weight: bold;">KHÁCH HÀNG</p>
                    <a href="#" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Báo giá - Khảo sát
                    </a>
                    <a href="{{ route('admin.contracts.index') }}" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Hợp đồng
                    </a>
                    <div class="dropdown-divider"></div>
                    <p class="dropdown-item" style="font-weight: bold;">KẾ HOẠCH</p>
                    <a href="#" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Nhập kế hoạch
                    </a>
                    <a href="#" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Xem và gửi
                    </a>
                    <div class="dropdown-divider"></div>
                    <p class="dropdown-item" style="font-weight: bold;">BÁO CÁO</p>
                    <a href="{{ route('admin.reports.index') }}" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Nhập báo cáo
                    </a>
                    <a href="#" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Xem và gửi
                    </a>
                    <div class="dropdown-divider"></div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    HỆ THỐNG
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: inherit; right: 0px;">
                    <p class="dropdown-item" style="font-weight: bold;">DATE/TIME</p>
                    <a href="{{ route('admin.accounts.index') }}" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Quản lý người dùng
                    </a>
                    <div class="dropdown-divider"></div>
                    <p class="dropdown-item" style="font-weight: bold;">HỆ THỐNG</p>
                    <a href="{{ route('admin.settings.backup') }}" style="padding-left: 40px" class="dropdown-item">
                        -&emsp;Sao lưu
                    </a>
                    <a href="#" style="padding-left: 40px" class="dropdown-item btn-restore-db">
                        -&emsp;Phục hồi dữ liệu
                    </a>
                    {{-- <a href="#" style="padding-left: 40px" class="dropdown-item">
                    -&emsp;Bảo trì hệ thống
                </a> --}}
                    <div class="dropdown-divider"></div>
                </div>
            </li>
        @endif
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                TRỢ GIÚP
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: inherit; right: 0px;">
                <p class="dropdown-item" style="font-weight: bold;">THÔNG TIN</p>
                <a href="#" style="padding-left: 40px" class="dropdown-item">
                    -&emsp;Kiến thức - Nghiệp vụ
                </a>
                <a href="#" style="padding-left: 40px" class="dropdown-item">
                    -&emsp;Phiên bản: VPSC.1215
                </a>
                <div class="dropdown-divider"></div>
                {{-- <a href="#" style="padding-left: 40px" class="dropdown-item">
                    -&emsp;Bảo trì hệ thống
                </a> --}}
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="fa-solid fa-gear"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: inherit; right: 0px;">
                <p class="dropdown-item" style="font-weight: bold;">Cài đặt</p>
                <a href="#" style="padding-left: 40px" class="dropdown-item" data-target="#modal"
                    data-toggle="modal">
                    -&emsp;Đổi mật khẩu
                </a>
                <a href="{{ route('users.logout') }}" style="padding-left: 40px" class="dropdown-item"
                    onclick="return confirm('Bạn có muốn đăng xuất?')" class="nav-link">
                    -&emsp;Đăng xuất
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
    </ul>
</nav>

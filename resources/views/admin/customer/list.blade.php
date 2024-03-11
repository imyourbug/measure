@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush
@push('scripts')
    <script src="/js/admin/customer/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Thêm khách hàng</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.customers.store') }}" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Tài khoản (Số điện thoại hoặc email)</label>
                                        <input type="text" class="form-control" name="tel_or_email"
                                            value="{{ old('tel_or_email') }}" placeholder="Nhập tài khoản">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Mật khẩu</label>
                                        <input type="password" class="form-control" id="name" name="password"
                                            value="{{ old('password') }}" placeholder="Nhập mật khẩu">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Họ tên</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="Nhập họ tên">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Địa chỉ</label>
                                        <input type="text" class="form-control" id="name" name="address"
                                            value="{{ old('address') }}" placeholder="Nhập địa chỉ">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Số điện thoại</label>
                                        <input type="text" class="form-control" name="tel"
                                            value="{{ old('tel') }}" placeholder="Nhập số điện thoại">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Email</label>
                                        <input type="email" class="form-control" id="name" name="email"
                                            value="{{ old('email') }}" placeholder="Nhập email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Thành phố</label>
                                        <input type="text" class="form-control" name="province"
                                            value="{{ old('province') }}" placeholder="Nhập thành phố">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Website</label>
                                        <input type="text" class="form-control" id="website" name="website"
                                            value="{{ old('website') }}" placeholder="Nhập website">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Người đại diện</label>
                                        <input type="text" class="form-control" name="representative"
                                            value="{{ old('representative') }}" placeholder="Nhập người đại diện">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Lĩnh vực</label>
                                        <input type="text" class="form-control" id="name" name="field"
                                            value="{{ old('field') }}" placeholder="Nhập lĩnh vực">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Người quản lý</label>
                                        <input type="text" class="form-control" name="manager"
                                            value="{{ old('manager') }}" placeholder="Nhập người quản lý">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Danh sách khách hàng</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Địa chỉ</th>
                                <th>Thành phố</th>
                                <th>Số điện thoại</th>
                                <th>Website</th>
                                <th>Đại diện khách hàng</th>
                                <th>Người quản lý</th>
                                <th>Email</th>
                                <th>Lĩnh vực</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

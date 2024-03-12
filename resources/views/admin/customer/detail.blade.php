@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.customers.update', ['id' => $customer->id]) }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Họ tên</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $customer->name }}"
                            placeholder="Nhập họ tên">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Địa chỉ</label>
                        <input type="text" class="form-control" id="name" name="address"
                            value="{{ old('address') ?? $customer->address }}" placeholder="Nhập địa chỉ">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Số điện thoại</label>
                        <input type="text" class="form-control" name="tel" value="{{ old('tel') ?? $customer->tel }}"
                            placeholder="Nhập số điện thoại">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="email" class="form-control" id="name" name="email"
                            value="{{ old('email') ?? $customer->email }}" placeholder="Nhập email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Thành phố</label>
                        <input type="text" class="form-control" name="province"
                            value="{{ old('province') ?? $customer->province }}" placeholder="Nhập thành phố">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Website</label>
                        <input type="text" class="form-control" id="website" name="website"
                            value="{{ old('website') ?? $customer->website }}" placeholder="Nhập website">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Người đại diện</label>
                        <input type="text" class="form-control" name="representative"
                            value="{{ old('representative') ?? $customer->representative }}"
                            placeholder="Nhập người đại diện">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Lĩnh vực</label>
                        <input type="text" class="form-control" id="name" name="field"
                            value="{{ old('field') ?? $customer->field }}" placeholder="Nhập lĩnh vực">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Người quản lý</label>
                        <input type="text" class="form-control" name="manager"
                            value="{{ old('manager') ?? $customer->manager }}" placeholder="Nhập người quản lý">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form>
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
            <h3 class="card-title text-bold">Thông tin hợp đồng</h3>
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
                        <th>Tên hợp đồng</th>
                        <th>Chi nhánh</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Nội dung</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customer->contracts as $key => $contract)
                        <tr class="row{{ $contract->id }}">
                            <th>{{ $contract->id }}</th>
                            <th>{{ $contract->name }}</th>
                            <th>{{ $contract->branch->name }}</th>
                            <td>{{ date('d-m-Y', strtotime($contract->start)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($contract->finish)) }}</td>
                            <td>{{ $contract->content }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href='{{ route('admin.contracts.show', ['id' => $contract->id]) }}'>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-success btn-sm" style="padding: 4px 15px"
                                    href='{{ route('admin.contracts.detail', ['id' => $contract->id]) }}'>
                                    <i class="fa-solid fa-info"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

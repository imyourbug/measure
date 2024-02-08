@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label for="menu">Họ tên</label>
                    <p class="form-control">{{ $customer->name }}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label for="menu">Địa chỉ</label>
                    <p class="form-control">{{ $customer->address }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label for="menu">Số điện thoại</label>
                    <p class="form-control">{{ $customer->tel }}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label for="menu">Email</label>
                    <p class="form-control">{{ $customer->email }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title text-bold">Hợp đồng</h3>
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
                        <th>Khách hàng</th>
                        <th>Thao tác</th>
                    </tr>
                <tbody>
                    @foreach ($customer->contracts as $key => $contract)
                        <tr class="row{{ $contract->id }}">
                            <th>{{ $contract->id }}</th>
                            <th>{{ $contract->name }}</th>
                            <th>{{ $contract->branch->name }}</th>
                            <td>{{ date('d-m-Y', strtotime($contract->start)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($contract->finish)) }}</td>
                            <td>{{ $contract->content }}</td>
                            <td>{{ $contract->customer->name }}</td>
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
                </thead>
            </table>
        </div>
    </div>
@endsection

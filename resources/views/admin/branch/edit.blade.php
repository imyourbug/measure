@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.branches.update', ['id' => $branch->id]) }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên chi nhánh</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $branch->name }}"
                            placeholder="Nhập tên chi nhánh">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Địa chỉ</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ old('address') ?? $branch->address }}" placeholder="Nhập địa chỉ">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="text" class="form-control" name="email"
                            value="{{ old('email') ?? $branch->email }}" placeholder="Nhập email">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Số điện thoại</label>
                        <input type="text" class="form-control" name="tel" value="{{ old('tel') ?? $branch->tel }}"
                            placeholder="Nhập số điện thoại">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Quản lý</label>
                        <input type="text" class="form-control" name="manager"
                            value="{{ old('manager') ?? $branch->manager }}" placeholder="Nhập quản lý">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Khách hàng</label>
                        <select class="form-control" name="user_id">
                            <option value="">--Khách hàng--</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->user_id }}"
                                    {{ $customer->user_id == $branch->user_id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{route('admin.branches.index')}}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form>
@endsection

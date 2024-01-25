@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.types.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên loại</label>
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name') }}" placeholder="Nhập tên loại">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Danh mục cha</label>
                        <select class="form-control" name="parent_id">
                            <option value="0">--Danh mục cha--</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{route('admin.types.index')}}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form>
@endsection

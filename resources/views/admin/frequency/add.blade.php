@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.frequencies.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày</label>
                        <input type="date" class="form-control" name="day" value="{{ old('day') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Lần</label>
                        <input type="text" class="form-control" name="time" value="{{ old('time') }}"
                            placeholder="Nhập số lần">
                    </div>
                </div>
                {{-- <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày</label>
                        <input type="text" class="form-control" name="day" value="{{ old('day') }}"
                            placeholder="Nhập ngày">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Tuần</label>
                        <input type="text" class="form-control" name="week" value="{{ old('week') }}"
                            placeholder="Nhập tuần">
                    </div>
                </div> --}}
            </div>
            {{-- <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Tháng</label>
                        <input type="text" class="form-control" name="month" value="{{ old('month') }}"
                            placeholder="Nhập tháng">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Năm</label>
                        <input type="text" class="form-control" name="year" value="{{ old('year') }}"
                            placeholder="Nhập năm">
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <label>Hiệu lực</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="active" value="1" name="active"
                                checked>
                            <label for="active" class="custom-control-label">Có</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="unactive" value="0" name="active">
                            <label for="unactive" class="custom-control-label">Không</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.frequencies.index') }}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form>
@endsection

@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.tasks.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày kế hoạch</label>
                        <input type="date" class="form-control" name="plan_date"
                            value="{{ old('plan_date') ?? now()->format('Y-m-d') }}" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Nhân sự</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Nhân sự--</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->staff->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Sơ đồ</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Sơ đồ--</option>
                            @foreach ($maps as $map)
                                <option value="{{ $map->id }}">{{ $map->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Hóa chất</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Hóa chất--</option>
                            @foreach ($chemistries as $chemistry)
                                <option value="{{ $chemistry->id }}">{{ $chemistry->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Phương pháp</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Phương pháp--</option>
                            @foreach ($solutions as $solution)
                                <option value="{{ $solution->id }}">{{ $solution->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Vật tư</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Vật tư--</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Phạm vi giới hạn</label>
                        <textarea placeholder="Nhập phạm vi giới hạn..." class="form-control" name="range" cols="30" rows="5">{{ old('range') }}</textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Lưu ý an toàn</label>
                        <textarea placeholder="Nhập lưu ý an toàn..." class="form-control" name="note" cols="30" rows="5">{{ old('note') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form>
@endsection

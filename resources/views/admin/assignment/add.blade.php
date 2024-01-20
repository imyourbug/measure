@extends('admin.main')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-search__field {
            border: none !important;
        }

        .select2-selection__choice__display {
            color: black;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/admin/assignment/index.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-type').select2();
        });
    </script>
@endpush
@section('content')
    {{-- <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
        <option value="a">a</option>
        <option value="b">v</option>
        <option value="c">b</option>
        <option value="d">c</option>
    </select> --}}
    <form action="{{ route('admin.assignments.update') }}" method="POST" class="">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Hợp đồng</label>
                        <select class="form-control select-contract" id="contract_id" name="contract_id" data-url="{{ route('contracts.getTypeByContractId') }}">
                            <option value="">--Hợp đồng--</option>
                            @foreach ($contracts as $contract)
                                <option value="{{ $contract->id }}">
                                    {{ $contract->name . '-' . $contract->branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Nhân viên</label>
                        <select class="form-control select-staff" id="user_id" name="user_id">
                            <option value="">--Nhân viên--</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->user->id }}">
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="start"
                            value="{{ old('start') ?? now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="finish"
                            value="{{ old('finish') ?? now()->format('Y-m-d') }}">
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Loại nhiệm vụ</label>
                        <select multiple="multiple" id="type" name="type[]"
                            class="select2 custom-select form-control-border select-type">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary btn-create">Lưu</button>
            <a href="{{ route('admin.assignments.index') }}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form>
@endsection

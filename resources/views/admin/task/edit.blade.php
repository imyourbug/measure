@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush
@push('scripts')
    <script src="/js/admin/task/edit.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                aria-selected="false">Sơ đồ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                                aria-selected="false">Nhân sự</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                                href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages"
                                aria-selected="false">Vật tư</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill"
                                href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings"
                                aria-selected="true">Hóa chất</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-solutions-tab" data-toggle="pill"
                                href="#custom-tabs-four-solutions" role="tab" aria-controls="custom-tabs-four-solutions"
                                aria-selected="true">Phương pháp</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane active show fade" id="custom-tabs-four-home" role="tabpanel"
                            aria-labelledby="custom-tabs-four-home-tab">
                            <button class="btn btn-success mb-4 btn-open-modal" data-target="#modal-map" data-toggle="modal">Thêm
                                mới</button>
                            <table id="tableMap" class="table-map table display nowrap dataTable dtr-inline collapsed">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã sơ đồ</th>
                                        <th>Vị trí</th>
                                        <th>Đối tượng</th>
                                        <th>Đơn vị</th>
                                        <th>KPI</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-four-profile-tab">
                            <button class="btn btn-success mb-4 btn-open-modal-staff" data-target="#modal-staff" data-toggle="modal">Thêm
                                mới</button>
                            <table id="tableStaff" class="table-staff table display nowrap dataTable dtr-inline collapsed">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã nhân viên</th>
                                        <th>Họ tên</th>
                                        <th>Chức vụ</th>
                                        <th>Số điện thoại</th>
                                        <th>CCCD</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                            aria-labelledby="custom-tabs-four-messages-tab">
                            a
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel"
                            aria-labelledby="custom-tabs-four-settings-tab">
                            b
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-solutions" role="tabpanel"
                            aria-labelledby="custom-tabs-four-solutions-tab">
                            b
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- add map --}}
    <div class="modal fade show" id="modal-map" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-map">Thêm sơ đồ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Sơ đồ</label>
                                <select class="form-control" name="" id="map_id">
                                    @foreach ($maps as $map)
                                        <option value="{{ $map->id }}">{{ $map->id . '-' . $map->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chỉ số</label>
                                <input class="form-control" type="text" id="unit" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">KPI</label>
                                <input class="form-control" type="text" id="kpi" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('taskmaps.store') }}"
                        class="btn btn-primary btn-add-map">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('taskmaps.update') }}"
                        class="btn btn-primary btn-update-map">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    {{-- add staff --}}
    <div class="modal fade show" id="modal-staff" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-staff">Thêm nhân sự</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Nhân sự</label>
                                <select class="form-control" name="" id="staff_id">
                                    @foreach ($staffs as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->id . '-' . $staff->staff->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('taskstaff.store') }}"
                        class="btn btn-primary btn-add-staff">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('taskstaff.update') }}"
                        class="btn btn-primary btn-update-staff">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    {{-- <form action="{{ route('admin.tasks.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Hợp đồng</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Hợp đồng--</option>
                            @foreach ($contracts as $contract)
                                <option value="{{ $contract->id }}">{{ $contract->name . '-' . $contract->branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Loại nhiệm vụ</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Loại nhiệm vụ--</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ghi chú</label>
                        <textarea placeholder="Nhập lưu ý an toàn..." class="form-control" name="note" cols="30" rows="5">{{ old('note') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form> --}}
    <input type="hidden" name="" value="{{ $task->id }}" id="task_id">
    <input type="hidden" name="" value="" id="taskmap_id">
    <input type="hidden" name="" value="" id="taskstaff_id">
@endsection

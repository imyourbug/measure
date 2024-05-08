@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
    <style>
        .tab-content {
            padding: 10px;
        }
    </style>
@endpush
@push('scripts')
    <script src="/js/admin/task/detail.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.12.0/js/dataTables.keyTable.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.12.0/js/keyTable.dataTables.js"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Danh sách</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    {{-- <a href="{{ route('admin.tasks.create') }}" class="btn btn-success">Thêm mới</a> --}}
                    {{-- <input class="" style="" type="date" name="from"
            value="{{ Request::get('from') ?? now()->format('Y-m-01') }}" />
        <input class="" style="" type="date" name="to"
            value="{{ Request::get('to') ?? now()->format('Y-m-t') }}" />
        <button class="btn btn-warning btn-filter" type="submit">Lọc</button> --}}
                    <div class="mb-2">
                        <button class="btn btn-success btn-open-modal" data-target="#modal" data-toggle="modal">Thêm
                            mới</button>
                    </div>
                    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Nhiệm vụ</th>
                                <th>Ngày kế hoạch</th>
                                <th>Ngày thực hiện</th>
                                <th>Giờ vào</th>
                                <th>Giờ ra</th>
                                <th>Ngày lập</th>
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
    <div class="modal fade" id="modal" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title modal-title-taskdetail">Cập nhật chi tiết nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Ngày kế hoạch <span class="required">(*)</span></label>
                                <input type="date" id="plan_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Ngày thực hiện</label>
                                <input type="date" id="actual_date" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Giờ vào <span class="required">(*)</span></label>
                                <input type="text" id="time_in" class="form-control" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Giờ ra <span class="required">(*)</span></label>
                                <input type="text" id="time_out" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('taskdetails.store') }}"
                        class="btn btn-primary btn-add-detail">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('taskdetails.update') }}"
                        class="btn btn-primary btn-update-detail">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Cài đặt</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                                href="#custom-tabs-four-home" role="tab"
                                                aria-controls="custom-tabs-four-home" aria-selected="false">Sơ đồ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                                href="#custom-tabs-four-profile" role="tab"
                                                aria-controls="custom-tabs-four-profile" aria-selected="false">Nhân sự</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-items-tab" data-toggle="pill"
                                                href="#custom-tabs-four-items" role="tab"
                                                aria-controls="custom-tabs-four-items" aria-selected="false">Vật tư</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-chemistries-tab" data-toggle="pill"
                                                href="#custom-tabs-four-chemistries" role="tab"
                                                aria-controls="custom-tabs-four-chemistries" aria-selected="true">Hóa
                                                chất</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-solutions-tab" data-toggle="pill"
                                                href="#custom-tabs-four-solutions" role="tab"
                                                aria-controls="custom-tabs-four-solutions" aria-selected="true">Phương
                                                pháp</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        {{-- Map --}}
                                        <div class="tab-pane active show fade" id="custom-tabs-four-home" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-home-tab">
                                            <button class="mb-2 btn btn-success btn-open-modal" data-target="#modal-map"
                                                data-toggle="modal">Thêm
                                                mới</button>
                                            <table id="tableMap"
                                                class="table-map table display nowrap dataTable dtr-inline collapsed">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="select-id-map-all" />
                                                            <button class="btn btn-danger btn-sm btn-delete-map-all"
                                                                style="display: none">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </th>
                                                        <!-- <th>ID</th> -->
                                                        <th>Mã sơ đồ</th>
                                                        <th>Vị trí</th>
                                                        <th>Đối tượng</th>
                                                        <th>Đơn vị</th>
                                                        <th>KPI</th>
                                                        <th>Kết quả dự kiến</th>
                                                        <th>Khu vực</th>
                                                        {{-- <th>Mô tả</th> --}}
                                                        <th>Phạm vi</th>
                                                        <th>Ảnh</th>
                                                        {{-- <th>Hiệu lực</th> --}}
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- Staff --}}
                                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-profile-tab">
                                            <button class="mb-2 btn btn-success btn-open-modal-staff"
                                                data-target="#modal-staff" data-toggle="modal">Thêm
                                                mới</button>
                                            <table id="tableStaff"
                                                class="table-staff table display nowrap dataTable dtr-inline collapsed">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>ID</th> -->
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
                                        {{-- Item --}}
                                        <div class="tab-pane fade" id="custom-tabs-four-items" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-items-tab">
                                            <button class="mb-2 btn btn-success btn-open-modal-item"
                                                data-target="#modal-item" data-toggle="modal">Thêm
                                                mới</button>
                                            <table id="tableItem"
                                                class="table-item table display nowrap dataTable dtr-inline collapsed">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>ID</th> -->
                                                        <th>Tên</th>
                                                        <th>Đơn vị</th>
                                                        <th>KPI</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- Chemistry --}}
                                        <div class="tab-pane fade" id="custom-tabs-four-chemistries" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-chemistries-tab">
                                            <button class="mb-2 btn btn-success btn-open-modal-chemistry"
                                                data-target="#modal-chemistry" data-toggle="modal">Thêm
                                                mới</button>
                                            <table id="tableChemistry"
                                                class="table-chemistry table display nowrap dataTable dtr-inline collapsed">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>ID</th> -->
                                                        <th>Tên</th>
                                                        <th>Đơn vị</th>
                                                        <th>KPI</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- Solution --}}
                                        <div class="tab-pane fade" id="custom-tabs-four-solutions" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-solutions-tab">
                                            <button class="mb-2 btn btn-success btn-open-modal-solution"
                                                data-target="#modal-solution" data-toggle="modal">Thêm
                                                mới</button>
                                            <table id="tableSolution"
                                                class="table-solution table display nowrap dataTable dtr-inline collapsed">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>ID</th> -->
                                                        <th>Tên</th>
                                                        <th>Đơn vị</th>
                                                        <th>KPI</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- add solution --}}
    <div class="modal fade" id="modal-solution" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-solution">Thêm phương pháp</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="">
                    <div class="">
                        <div class=""></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Phương pháp <span class="required">(*)</span></label>
                                <select class="form-control" name="" id="solution_id">
                                    @foreach ($solutions as $solution)
                                        <option value="{{ $solution->id }}">
                                            {{ $solution->id . '-' . $solution->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Đơn vị <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="solution_unit" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">KPI <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="solution_kpi" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('settingtasksolutions.store') }}"
                        class="btn btn-primary btn-add-solution">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('settingtasksolutions.update') }}"
                        class="btn btn-primary btn-update-solution">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    {{-- add item --}}
    <div class="modal fade" id="modal-item" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-item">Thêm vật tư</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="">
                    <div class="">
                        <div class=""></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Vật tư <span class="required">(*)</span></label>
                                <select class="form-control" name="" id="item_id">
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->id . '-' . $item->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Đơn vị <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="item_unit" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">KPI <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="item_kpi" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('settingtaskitems.store') }}"
                        class="btn btn-primary btn-add-item">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('settingtaskitems.update') }}"
                        class="btn btn-primary btn-update-item">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    {{-- add map --}}
    <div class="modal fade" id="modal-map" style="display: none;" aria-modal="true" role="dialog">
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
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Số lượng sơ đồ <span class="required">(*)</span></label>
                                <input type="number" class="form-control" id="number" value="1"
                                    placeholder="Nhập số lượng sơ đồ">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Mã sơ đồ <span class="required">(*)</span></label>
                                <input type="text" class="form-control" id="code" value=""
                                    placeholder="Nhập mã sơ đồ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Vị trí</label>
                                <input type="text" class="form-control" id="position" value=""
                                    placeholder="Nhập vị trí">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Đối tượng</label>
                                <input type="text" class="form-control" id="target" value=""
                                    placeholder="Nhập đối tượng">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Đơn vị <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="unit" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">KPI <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="kpi" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Kết quả dự kiến</label>
                                <input class="form-control" type="text" id="fake_result" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Khu vực</label>
                                <input type="text" class="form-control" id="area" value=""
                                    placeholder="Nhập khu vực" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Mô tả</label>
                                <input class="form-control" id="description" placeholder="Nhập mô tả" />
                            </div>
                        </div> --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Phạm vi</label>
                                <input type="text" class="form-control" id="range" value=""
                                    placeholder="Nhập phạm vi" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="file">Chọn ảnh</label><br>
                                <div class="">
                                    <img id="image_show" style="width: 100px;height:100px" src=""
                                        alt="image" />
                                    <input type="file" id="upload" accept=".png,.jpeg" />
                                </div>
                                <input type="hidden" id="image" value="">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>Hiệu lực</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="active" value="1"
                                        name="active" checked>
                                    <label for="active" class="custom-control-label">Có</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="unactive" value="0"
                                        name="active">
                                    <label for="unactive" class="custom-control-label">Không</label>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('settingtaskmaps.store') }}"
                        class="btn btn-primary btn-add-map">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('settingtaskmaps.update') }}"
                        class="btn btn-primary btn-update-map">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    {{-- add staff --}}
    <div class="modal fade" id="modal-staff" style="display: none;" aria-modal="true" role="dialog">
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
                                <label for="menu">Nhân sự <span class="required">(*)</span></label>
                                <select class="form-control" name="" id="staff_id">
                                    @foreach ($staffs as $staff)
                                        <option value="{{ $staff->id }}">
                                            {{ $staff->id . '-' . $staff->staff->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('settingtaskstaff.store') }}"
                        class="btn btn-primary btn-add-staff">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('settingtaskstaff.update') }}"
                        class="btn btn-primary btn-update-staff">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    {{-- add chemistry --}}
    <div class="modal fade" id="modal-chemistry" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title-chemistry">Thêm hóa chất</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="">
                    <div class="">
                        <div class=""></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Hóa chất <span class="required">(*)</span></label>
                                <select class="form-control" name="" id="chemistry_id">
                                    @foreach ($chemistries as $chemistry)
                                        <option value="{{ $chemistry->id }}">
                                            {{ $chemistry->id . '-' . $chemistry->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Đơn vị <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="chemistry_unit" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">KPI <span class="required">(*)</span></label>
                                <input class="form-control" type="text" id="chemistry_kpi" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('settingtaskchemistries.store') }}"
                        class="btn btn-primary btn-add-chemistry">Lưu</button>
                    <button style="display: none" type="button" data-url="{{ route('settingtaskchemistries.update') }}"
                        class="btn btn-primary btn-update-chemistry">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    {{-- <input type="hidden" name="" value="{{ $taskDetail->id }}" id="task_id"> --}}
    <input type="hidden" name="" value="" id="settingtaskstaff_id">
    <input type="hidden" name="" value="" id="settingtaskchemistry_id">
    <input type="hidden" name="" value="" id="settingtaskitem_id">
    <input type="hidden" name="" value="" id="settingtasksolution_id">
    <input type="hidden" name="" value="" id="settingtaskmap_id">
    <input type="hidden" id="task_id" value="{{ request()->id }}" />
    <input type="hidden" id="taskdetail_id" />
@endsection

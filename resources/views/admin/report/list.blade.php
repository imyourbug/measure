@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <a href="" target="_blank"></a>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/admin/report/index.js"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Sao chép dữ liệu</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.reports.duplicate') }}" method="post">
                        @csrf
                        <div class="card-body" style="display: block;padding: 10px !important;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Chọn hợp đồng <span class="required">(*)</span></label>
                                        <select name="contract_id" class="form-control">
                                            @foreach ($contracts as $contract)
                                                <option value="{{ $contract->id }}">
                                                    {{ $contract->customer->name . ' | ' . $contract->name . ' | ' . ($contract->branch->name ?? '') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Từ tháng <span class="required">(*)</span></label>
                                        <select name="month_from" class="form-control">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == now()->format('m') ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Từ năm <span class="required">(*)</span></label>
                                        <input name="year_from" class="form-control" type="text"
                                            value="{{ now()->format('Y') }}" placeholder="Nhập năm..." />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Sang tháng <span class="required">(*)</span></label>
                                        <select name="month_to" class="form-control">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == now()->format('m') ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Sang năm <span class="required">(*)</span></label>
                                        <input name="year_to" class="form-control" type="text"
                                            value="{{ now()->format('Y') }}" placeholder="Nhập năm..." />
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Báo cáo</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn loại báo cáo <span class="required">(*)</span></label>
                                <select class="form-control select-type">
                                    <option value="0">
                                        KẾ HOẠCH THỰC HIỆN DỊCH VỤ
                                    </option>
                                    <option value="1">
                                        KẾ HOẠCH CHI TIẾT
                                    </option>
                                    <option value="2">
                                        BÁO CÁO ĐÁNH GIÁ KẾT QUẢ THỰC HIỆN DỊCH VỤ
                                    </option>
                                    <option value="3">
                                        BIÊN BẢN NGHIỆM THU CÔNG VIỆC HOÀN THÀNH
                                    </option>
                                    <option value="4" selected>
                                        BIÊN BẢN XÁC NHẬN KHỐI LƯỢNG HOÀN THÀNH-BÁO CÁO CHI TIẾT
                                    </option>
                                    <option value="5">
                                        BẢNG KÊ CÔNG VIỆC/DỊCH VỤ
                                    </option>
                                    <option value="6">
                                        BIÊN BẢN XÁC NHẬN CÔNG VIỆC/DỊCH VỤ
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn hợp đồng <span class="required">(*)</span></label>
                                <select class="form-control select-contract">
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}">
                                            {{ $contract->customer->name . ' | ' . $contract->name . ' | ' . ($contract->branch->name ?? '') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn tháng <span class="required">(*)</span></label>
                                <select class="form-control select-month">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ $i == now()->format('m') ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn năm <span class="required">(*)</span></label>
                                <input class="form-control select-year" type="text" value="{{ now()->format('Y') }}"
                                    placeholder="Nhập năm..." />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn tháng so sánh<span class="required">(*)</span></label>
                                <select class="form-control select-month-compare">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ $i == now()->format('m') ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Năm so sánh <span class="required">(*)</span></label>
                                <input value="{{ date('Y') - 1 }}" type="text"
                                    class="form-control year_compare select-year-compare">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn người lập báo cáo <span class="required">(*)</span></label>
                                <select class="form-control select-user">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Số lượng cột hiển thị <span class="required">(*)</span></label>
                                <input value="10" min="1" type="number" id="select-column"
                                    class="form-control select-column" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Lựa chọn</label>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display"
                                        class="option-type custom-control-input">
                                    <label class="custom-control-label" for="select-display">Hiển thị ảnh</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-preview" data-target="#modal-export" data-toggle="modal">Xuất
                        PDF</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
            <h3 class="card-title text-bold">Nhập dữ liệu báo cáo</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;padding: 10px !important;">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <label for="">Thời gian</label>
                    <input id="select-time" class="form-control" type="month" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <label for="">Lựa chọn hợp đồng</label>
                    <select multiple="multiple" class="select2 custom-select form-control-border select">
                        @foreach ($contracts as $contract)
                            <option value="{{ $contract->id }}">
                                {{ $contract->customer->name . ' | ' . $contract->name . ' | ' . ($contract->branch->name ?? '') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>Nhiệm vụ</th>
                        <th>Hợp đồng</th>
                        <th>Ghi chú</th>
                        <th>Tần suất</th>
                        <th>Xác nhận</th>
                        <th>Hiện trạng</th>
                        <th>Nguyên nhân</th>
                        <th>Biện pháp</th>
                        <th>Ngày lập</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-title">Cập nhật nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Loại nhiệm vụ <span class="required">(*)</span></label>
                                <select class="form-control" id="type_id">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->id . '-' . $type->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Hợp đồng</label>
                                <select class="form-control select-contract" id="contract_id">
                                    <option value="">--Hợp đồng--</option>
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}">
                                            {{ $contract->name . '-' . ($contract->branch->name ?? '') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Tần suất</label>
                                <input class="form-control" type="text" id="frequence" placeholder="Nhập tần suất" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Xác nhận</label>
                                <input class="form-control" type="text" id="confirm" placeholder="Nhập xác nhận" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Hiện trạng</label>
                                <input class="form-control" type="text" id="status"
                                    placeholder="Nhập hiện trạng" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Nguyên nhân</label>
                                <input class="form-control" type="text" id="reason"
                                    placeholder="Nhập nguyên nhân" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Biện pháp</label>
                                <input class="form-control" type="text" placeholder="Nhập biện pháp"
                                    id="solution" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Ghi chú <span class="required">(*)</span></label>
                                <input class="form-control" type="text" placeholder="Nhập ghi chú..."
                                    id="note" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" data-url="{{ route('tasks.update') }}"
                        class="btn btn-primary btn-update">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-export" style="display:none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content modal-content-export">
                <form action="{{ route('exports.plan') }}" method="POST" id="form-export">
                    <div class="modal-header">
                        <h4 class="modal-title">Xuất báo cáo?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    {{-- <div style="" class="allChart">
                        <div class="groupChart blockChart" style="">
                        </div>
                        <div class="groupTrendChart blockChart" style="">
                        </div>
                        <div class="groupAnnualChart blockChart" style="">
                        </div>
                    </div> --}}
                    <div class="groupImage">
                    </div>
                    <div class="groupTrendImage">
                    </div>
                    <div class="groupAnnualImage">
                    </div>
                    <input type="hidden" class="month" name="month" />
                    <input type="hidden" class="year" name="year" />
                    <input type="hidden" class="type_report" name="type_report" />
                    <input type="hidden" class="contract_id" name="contract_id" />
                    <input type="hidden" class="user_id" name="user_id" />
                    <input type="hidden" class="display" name="display" />
                    <input type="hidden" class="year_compare" name="year_compare" />
                    <input type="hidden" class="month_compare" name="month_compare" />
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-default" data-dismiss="modal">Đóng</button>
                        {{-- <button type="submit" class="btn btn-primary btn-export" disabled>Xác nhận</button> --}}
                        <button type="submit" class="btn btn-primary btn-export">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="task_id">
    <div style="" class="allChart">
        <div class="groupChart blockChart" style="">
        </div>
        <div class="groupTrendChart blockChart" style="">
        </div>
        <div class="groupAnnualChart blockChart" style="">
        </div>
    </div>
@endsection

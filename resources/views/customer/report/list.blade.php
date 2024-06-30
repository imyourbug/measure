@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <a href="" target="_blank"></a>
@endpush
@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.12.0/js/dataTables.keyTable.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.12.0/js/keyTable.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="/js/customer/report/index.js"></script>
@endpush
@section('content')
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
                                <label for="menu">Chọn năm <span class="required">(*)</span>&emsp13;<input checked
                                        type="checkbox" name="" id="display-year" /></label>
                                <input class="form-control select-year" type="text" value="{{ now()->format('Y') }}"
                                    placeholder="Nhập năm..." />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn tháng so sánh<span class="required">(*)</span>&emsp13;<input
                                        checked type="checkbox" name="" id="display-month-compare" /></label>
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
                                <label for="menu">Năm so sánh <span class="required">(*)</span>&emsp13;<input checked
                                        type="checkbox" name="" id="display-year-compare" /></label>
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
                                    @foreach ($staff as $s)
                                        <option value="{{ $s->id }}">
                                            {{ $s->name }}
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
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="select-display">Hiển thị ảnh</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display-first"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="select-display-first">Hiển thị ảnh đầu (trong
                                        1 tháng)</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display-second"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="select-display-second">Hiển thị ảnh giữa (so
                                        sánh 2 tháng)</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display-third"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="select-display-third">Hiển thị ảnh cuối (diễn
                                        biến từng tháng)</label>
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
                    <input type="hidden" class="display-first" name="display_first" />
                    <input type="hidden" class="display-second" name="display_second" />
                    <input type="hidden" class="display-third" name="display_third" />
                    {{--  --}}
                    <input type="hidden" class="display-year" name="display_year" />
                    <input type="hidden" class="display-month-compare" name="display_month_compare" />
                    <input type="hidden" class="display-year-compare" name="display_year_compare" />
                    {{--  --}}
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
    <div style="margin-top:400px" class="allChart">
        <div class="groupChart blockChart" style="">
        </div>
        <div class="groupTrendChart blockChart" style="">
        </div>
        <div class="groupAnnualChart blockChart" style="">
        </div>
    </div>
@endsection

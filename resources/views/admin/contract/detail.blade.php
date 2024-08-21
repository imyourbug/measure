@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endpush
@push('scripts')
    <script src="/js/admin/contract/detail.js"></script>
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
    <script>
        $(document).on('change', '#attachment', function() {
            const form = new FormData();
            form.append("file", $(this)[0].files[0]);
            $.ajax({
                processData: false,
                contentType: false,
                type: "POST",
                data: form,
                url: "/api/upload",
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success('Tải lên thành công', 'Thông báo');
                        $("#value-attachment").val(response.url);
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
            });
        });

        $(document).on('click', '.btn-remove-image', function(event) {
            let id = $(this).data('id');

            $.ajax({
                type: "DELETE",
                url: `/api/upload/deleteImage/${id}`,
                success: function(response) {
                    if (response.status == 0) {
                        $(`.image-task[data-id="${id}"]`).remove();
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
            });
        });

        $(document).on('submit', '#upload-form', function(event) {
            event.preventDefault(); // Prevent default form submission
            var formData = new FormData(this); // Create FormData object
            let task_id = $('#task_id').val();
            formData.append('task_id', task_id);

            $.ajax({
                processData: false,
                contentType: false,
                type: "POST",
                data: formData,
                url: "/api/upload/multipleimages",
                success: function(response) {
                    if (response.status == 0) {
                        //hiển thị ảnh
                        response.images.forEach((image) => {
                            $('.block-image').append(`<span class="image-task" data-id="${image.id}" style="position: relative;">
                                <img style="width: 100px;height:100px" src="${image.url}" data-id="${image.id}" data-task_id="${image.task_id}"
                                    alt="image" />
                                <span class="btn btn-sm btn-danger" style="right:0px;position: absolute;">
                                    <i data-id="${image.id}"
                                        class="fa-solid fa-trash btn-remove-image"></i>
                                </span>
                            </span>`);
                        })
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
            });
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">{{ $title }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body form-contract" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.contracts.update', ['id' => $contract->id]) }}" method="POST"
                        class="form-contract">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Tên hợp đồng <span class="required">(*)</span></label>
                                        <input class="form-control" type="text" name="name"
                                            value="{{ old('name') ?? $contract->name }}"
                                            placeholder="Nhập tên hợp đồng..." />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Khách hàng <span class="required">(*)</span></label>
                                        <select class="form-control" name="customer_id">
                                            <option value="">--Khách hàng--</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ $customer->id == $contract->customer_id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Ngày bắt đầu <span class="required">(*)</span></label>
                                        <input type="date" class="form-control" id="start" name="start"
                                            value="{{ old('start') ?? $contract->start }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Ngày kết thúc <span class="required">(*)</span></label>
                                        <input type="date" class="form-control" id="finish" name="finish"
                                            value="{{ old('finish') ?? $contract->finish }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Ngày</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                            value="{{ old('date') ?? $contract->date }}">
                                    </div>
                                </div>
                                 <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Chi nhánh</label>
                                        <input class="form-control" type="text" disabled
                                            value="{{ $contract->branch->name ?? '' }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="menu">Nội dung</label>
                                        <textarea placeholder="Nhập nội dung..." class="form-control" name="content" cols="30" rows="5">{{ old('content') ?? $contract->content }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group form-attachment">
                                        <label class="notification" for="menu">Tệp đính kèm</label>
                                        <div class="">
                                            <input type="file" id="attachment">
                                            <input type="hidden" name="attachment" id="value-attachment"
                                                value="{{ $contract->attachment }}">
                                        </div>
                                        @if ($contract->attachment)
                                            <a href="{{ $contract->attachment }}" target="_blank">Xem</a>
                                        @else
                                            Trống
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-create">Lưu</button>
                            <a href="{{ route('admin.contracts.index') }}" class="btn btn-success">Xem danh sách</a>
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
                                <label for="menu">Lựa chọn</label>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display"
                                        class="option-type custom-control-input">
                                    <label class="custom-control-label" for="select-display">Hiển thị ảnh</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display-first"
                                        class="option-type custom-control-input">
                                    <label class="custom-control-label" for="select-display-first">Hiển thị ảnh đầu (trong
                                        1 tháng)</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display-second"
                                        class="option-type custom-control-input">
                                    <label class="custom-control-label" for="select-display-second">Hiển thị ảnh giữa (so
                                        sánh 2 tháng)</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input checked value="1" type="checkbox" id="select-display-third"
                                        class="option-type custom-control-input">
                                    <label class="custom-control-label" for="select-display-third">Hiển thị ảnh cuối (diễn
                                        biến từng tháng)</label>
                                </div>
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
                    <input type="hidden" class="select-contract" value="{{ request()->id }}" />
                    <button class="btn btn-danger btn-preview" data-target="#modal-export" data-toggle="modal">Xuất
                        PDF</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
            <h3 class="card-title text-bold">Nhiệm vụ</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;padding: 10px !important;">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="menu">Thời gian lập</label>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <input type="date" class="form-control" data-name="Ngày lập" id="from"
                                    value="{{ date('Y-m-01') }}">
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <input type="date" class="form-control" data-name="Ngày lập" id="to"
                                    value="{{ date('Y-m-t') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-warning btn-filter">Lọc</button>
            <button class="btn btn-success btn-refresh">Tất cả</button>
            <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>Nhiệm vụ</th>
                        <th>Hợp đồng</th>
                        <th>Tần suất</th>
                        <th>Xác nhận</th>
                        <th>Hiện trạng</th>
                        <th>Nguyên nhân</th>
                        <th>Biện pháp</th>
                        <th>Ghi chú</th>
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
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="file">Chọn ảnh</label><br>
                                <div class="block-image">
                                </div>
                                <input type="hidden" name="images[]" id="images" accept=".png,.jpeg" />
                                <form id="upload-form" enctype="multipart/form-data">
                                    <input type="file" id="files" name="files[]" multiple>
                                    <br>
                                    <button class="btn btn-sm btn-success mt-2" type="submit">Tải lên file</button>
                                </form>
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
                    <div class="groupImage">
                    </div>
                    <div class="groupTrendImage">
                    </div>
                    <div class="groupAnnualImage">
                    </div>
                    {{-- <div class="groupChart" style="display: block;">
                    </div>
                    <div class="groupTrendChart" style="display: block;">
                    </div>
                    <div class="groupAnnualChart" style="display: block;">
                    </div> --}}
                    <input type="hidden" class="month" name="month" />
                    <input type="hidden" class="year" name="year" />
                    <input type="hidden" class="type_report" name="type_report" />
                    <input type="hidden" class="contract_id" value="{{ request()->id }}" name="contract_id" />
                    <input type="hidden" class="user_id" name="user_id" />
                    <input type="hidden" class="column" name="column" />
                    {{--  --}}
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
                        <button type="submit" class="btn btn-primary btn-export" disabled>Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="task_id" />
    <input type="hidden" id="request_contract_id" value="{{ request()->id }}" />
    <div style="" class="allChart">
        <div class="groupChart blockChart" style="">
        </div>
        <div class="groupTrendChart blockChart" style="">
        </div>
        <div class="groupAnnualChart blockChart" style="">
        </div>
    </div>
@endsection

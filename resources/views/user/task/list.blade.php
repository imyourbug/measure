@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush
@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="/js/user/task/index.js?v=1" type="text/javascript"></script>
@endpush
@section('content')
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title text-bold">Danh sách nhiệm vụ</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;padding: 10px !important;">
            <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nhiệm vụ</th>
                        <th>Ghi chú</th>
                        <th>Ngày lập</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($contract->tasks as $task)
                        <tr class="row{{ $task->id }}">
                            <th>{{ $task->id }}</th>
                            <th>{{ $task->type->name }}</th>
                            <td>{{ $task->note ?? 'Trống' }}</td>
                            <td>{{ date('d-m-Y', strtotime($task->created_at)) }}</td>
                            <td><a class="btn btn-primary btn-sm"
                                    href='{{ route('admin.tasks.show', ['id' => $task->id]) }}'>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button data-id="{{ $task->id }}" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade show" id="modal" style="display: none; padding-right: 17px;" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Số điện</label>
                                <input type="text" class="form-control" id="amount" value="0"
                                    placeholder="Nhập số điện">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id_task">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary btn-save">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    {{-- <input type="hidden" class="url_update_elec" value="{{ route('tasks.updateElecTask') }}"> --}}
@endsection

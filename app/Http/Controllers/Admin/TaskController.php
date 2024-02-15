<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Chemistry;
use App\Models\Contract;
use App\Models\Item;
use App\Models\Map;
use App\Models\Solution;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Models\TaskMap;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;
use Toastr;

class TaskController extends Controller
{
    public function create()
    {
        return view('admin.task.add', [
            'title' => 'Thêm nhiệm vụ',
            'staffs' => User::with('staff')->where('role', GlobalConstant::ROLE_STAFF)->get(),
            'contracts' => Contract::with(['branch'])->get(),
            'items' => Item::all(),
            'maps' => Map::all(),
            'types' => Type::all(),
            'solutions' => Solution::all(),
            'chemistries' => Chemistry::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // 'name' => 'required|string',
            'type_id' => 'required|numeric',
            'contract_id' => 'required|numeric',
            'note' => 'nullable|string',
        ]);
        try {
            Task::create($data);
            Toastr::success('Tạo thành công', __('title.toastr.fail'));
        } catch (Throwable $e) {
            dd($e);
            Toastr::error('Tạo nhiệm vụ thất bại', __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'note' => 'required|string',
            'type_id' => 'required|numeric',
            'contract_id' => 'required|numeric',
        ]);
        unset($data['id']);
        try {
            Task::where('id', $request->input('id'))->update($data);
            return response()->json([
                'status' => 0,
                'message' => 'Cập nhật nhiệm vụ thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function index(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $tasks = Task::with([
            'contract.branch', 'type',
        ])
            ->when($from, function ($q) use ($from) {
                return $q->where('created_at', '>=', $from . ' 00:00:00');
            })->when($to, function ($q) use ($to) {
                return $q->where('created_at', '<=', $to . ' 23:59:59');
            })->get();

        return view('admin.task.list', [
            'title' => 'Danh sách nhiệm vụ',
            'tasks' => $tasks,
            'contracts' => Contract::with(['branch'])->get(),
            'types' => Type::all(),
        ]);
    }

    public function getAll(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $contracts = !empty($request->contracts) ? explode(",", $request->contracts) : [];
        $tasks = Task::with([
            'contract.branch', 'type',
        ])
            ->when($from, function ($q) use ($from) {
                return $q->where('created_at', '>=', $from . ' 00:00:00');
            })->when($to, function ($q) use ($to) {
                return $q->where('created_at', '<=', $to . ' 23:59:59');
            })->when($contracts, function ($q) use ($contracts) {
                return $q->whereHas('contract', function ($q) use ($contracts) {
                    $q->whereIn('id', $contracts);
                });
            })
            ->get();
        return response()->json([
            'status' => 0,
            'tasks' => $tasks
        ]);
    }

    public function getById($id)
    {
        return response()->json([
            'status' => 0,
            'task' => Task::with(['contract', 'type',])->firstWhere('id', $id)
        ]);
    }

    public function show($id, Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $tasks = TaskDetail::with([
            'task',
        ])
            ->when($from, function ($q) use ($from) {
                return $q->where('created_at', '>=', $from . ' 00:00:00');
            })->when($to, function ($q) use ($to) {
                return $q->where('created_at', '<=', $to . ' 23:59:59');
            })->get();
        return view('admin.task.detail', [
            'title' => 'Danh sách chi tiết nhiệm vụ',
            'tasks' => $tasks,
            'contracts' => Contract::with(['branch'])->get(),
            'types' => Type::all(),
        ]);
    }

    public function destroy($id)
    {
        try {
            Task::firstWhere('id', $id)->delete();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
}

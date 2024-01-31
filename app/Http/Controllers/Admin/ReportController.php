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

class ReportController extends Controller
{
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

        return view('admin.report.list', [
            'title' => 'Báo cáo nhiệm vụ',
            'tasks' => $tasks,
            'contracts' => Contract::with(['branch'])->get(),
            'types' => Type::all(),
        ]);
    }

    public function task($id, Request $request)
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
            })
            ->where('task_id', $id)
            ->get();

        return view('admin.report.task.index', [
            'title' => 'Danh sách báo cáo chi tiết nhiệm vụ',
            'tasks' => $tasks,
            'contracts' => Contract::with(['branch'])->get(),
            'types' => Type::all(),
        ]);
    }

    // public function show($id, Request $request)
    // {
    //     $from = $request->from;
    //     $to = $request->to;
    //     $tasks = TaskDetail::with([
    //         'task',
    //     ])
    //         ->when($from, function ($q) use ($from) {
    //             return $q->where('created_at', '>=', $from . ' 00:00:00');
    //         })->when($to, function ($q) use ($to) {
    //             return $q->where('created_at', '<=', $to . ' 23:59:59');
    //         })->get();
    //     return view('admin.report.detail', [
    //         'title' => 'Danh sách chi tiết nhiệm vụ',
    //         'tasks' => $tasks,
    //         'contracts' => Contract::with(['branch'])->get(),
    //         'types' => Type::all(),
    //     ]);
    // }

    public function detail($id, Request $request)
    {
        return view('admin.report.task.detail', [
            'title' => 'Chi tiết nhiệm vụ',
            'taskDetail' => TaskDetail::with(['task.type'])->firstWhere('id', $id),
            'staffs' => User::with('staff')->where('role', GlobalConstant::ROLE_STAFF)->get(),
            'types' => Type::all(),
            'chemistries' => Chemistry::all(),
            'solutions' => Solution::all(),
            'items' => Item::all(),
            'maps' => Map::all(),
            'contracts' => Contract::with(['branch'])->get(),
            'taskMaps' => TaskMap::with(['task', 'map'])->where('task_id', $id)->get(),
        ]);
    }
}

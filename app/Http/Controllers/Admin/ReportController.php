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
use App\Models\TaskChemistry;
use App\Models\TaskDetail;
use App\Models\TaskMap;
use App\Models\TaskSolution;
use App\Models\TaskStaff;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'users' => User::with(['staff'])->where('role', GlobalConstant::ROLE_STAFF)->get(),
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

    public function duplicate(Request $request)
    {
        $data = $request->validate([
            'month_from' => 'required|numeric',
            'month_to' => 'required|numeric',
            'year_from' => 'required|numeric',
            'year_to' => 'required|numeric',
            'contract_id' => 'required|numeric',
        ]);
        if ($data['month_from'] === $data['month_to'] && $data['year_from'] === $data['year_to']) {
            Toastr::error('Hãy chọn 2 tháng khác nhau', __('title.toastr.fail'));

            return redirect()->back();
        }
        $contract = Contract::with([
            'tasks.details.taskChemitries',
            'tasks.details.taskMaps',
            'tasks.details.taskSolutions',
            'tasks.details.taskItems',
            'tasks.details.taskStaffs',
        ])
            ->whereHas('tasks.details', function ($q) use ($data) {
                $q->whereRaw('MONTH(plan_date) = ?', $data['month_from'])
                    ->whereRaw('YEAR(plan_date) = ?', $data['year_from']);
            })
            ->firstWhere('id', $data['contract_id']);
        DB::beginTransaction();
        try {
            foreach ($contract->tasks as $task) {
                foreach ($task->details as $detail) {
                    $plan_date = $detail->plan_date->format($data['year_to'] . '-' . $data['month_to'] . '-d');
                    $date = explode( '-', $plan_date);
                    if (checkdate((int) $date[1], (int) $date[2], (int) $date[0])) {
                        $newDetail = TaskDetail::create(
                            [
                                'plan_date' => $plan_date,
                                'time_in' => $detail->time_in,
                                'time_out' => $detail->time_out,
                                'range' => $detail->range,
                                'note' => $detail->note,
                                'task_id' => $detail->task_id,
                            ]
                        );
                        // taskChemitry
                        foreach ($detail->taskChemitries as $taskChemitry) {
                            TaskChemistry::create(
                                [
                                    'code' => $taskChemitry->code,
                                    'name' => $taskChemitry->name,
                                    'unit' => $taskChemitry->unit,
                                    'kpi' => $taskChemitry->kpi,
                                    'result' => $taskChemitry->result,
                                    'image' => $taskChemitry->image,
                                    'detail' => $taskChemitry->detail,
                                    'chemistry_id' => $taskChemitry->chemistry_id,
                                    'task_id' => $newDetail->id,
                                ]
                            );
                        }
                        // taskMap
                        foreach ($detail->taskMaps as $taskMap) {
                            TaskMap::create(
                                [
                                    'code' => $taskMap->code,
                                    'area' => $taskMap->area,
                                    'position' => $taskMap->position,
                                    'target' => $taskMap->target,
                                    'unit' => $taskMap->unit,
                                    'kpi' => $taskMap->kpi,
                                    'result' => $taskMap->result,
                                    'image' => $taskMap->image,
                                    'detail' => $taskMap->detail,
                                    'round' => $taskMap->round,
                                    'map_id' => $taskMap->map_id,
                                    'task_id' => $newDetail->id,
                                ]
                            );
                        }
                        // taskSolution
                        foreach ($detail->taskSolutions as $taskSolution) {
                            TaskSolution::create(
                                [
                                    'code' => $taskSolution->code,
                                    'name' => $taskSolution->name,
                                    'position' => $taskSolution->position,
                                    'unit' => $taskSolution->unit,
                                    'kpi' => $taskSolution->kpi,
                                    'result' => $taskSolution->result,
                                    'image' => $taskSolution->image,
                                    'detail' => $taskSolution->detail,
                                    'solution_id' => $taskSolution->solution_id,
                                    'task_id' => $newDetail->id,
                                ]
                            );
                        }
                        // taskItem
                        foreach ($detail->taskItems as $taskItem) {
                            TaskItem::create(
                                [
                                    'code' => $taskItem->code,
                                    'name' => $taskItem->name,
                                    'unit' => $taskItem->unit,
                                    'kpi' => $taskItem->kpi,
                                    'result' => $taskItem->result,
                                    'image' => $taskItem->image,
                                    'detail' => $taskItem->detail,
                                    'item_id' => $taskItem->item_id,
                                    'task_id' => $newDetail->id,
                                ]
                            );
                        }
                        // taskStaff
                        foreach ($detail->taskStaffs as $taskStaff) {
                            TaskStaff::create(
                                [
                                    'code' => $taskStaff->code,
                                    'name' => $taskStaff->name,
                                    'position' => $taskStaff->position,
                                    'tel' => $taskStaff->tel,
                                    'identification' => $taskStaff->identification,
                                    'user_id' => $taskStaff->user_id,
                                    'task_id' => $newDetail->id,
                                ]
                            );
                        }
                    }
                }
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), __('title.toastr.fail'));

            return redirect()->back();
        }
        DB::commit();
        Toastr::success('Sao chép thành công', __('title.toastr.success'));

        return redirect()->back();
    }
}

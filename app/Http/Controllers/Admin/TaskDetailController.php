<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Chemistry;
use App\Models\Contract;
use App\Models\Item;
use App\Models\Map;
use App\Models\Solution;
use App\Models\TaskDetail;
use App\Models\TaskMap;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class TaskDetailController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'time_in' => 'required|string',
            'time_out' => 'required|string',
            'plan_date' => 'required|date',
            'actual_date' => 'nullable|date',
            'task_id' => 'required|numeric',
        ]);
        try {
            TaskDetail::create($data);
            return response()->json([
                'status' => 0,
                'message' => 'Tạo thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'time_in' => 'required|string',
            'time_out' => 'required|string',
            'plan_date' => 'required|date',
            'actual_date' => 'nullable|date',
        ]);
        unset($data['id']);
        try {
            TaskDetail::where('id', $request->input('id'))->update($data);
            return response()->json([
                'status' => 0,
                'message' => 'Cập nhật thành công'
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
        return response()->json([
            'status' => 0,
            'taskDetails' => TaskDetail::with(['task.type'])->where('task_id', $request->id)->get(),
        ]);
    }

    public function getById(Request $request)
    {
        return response()->json([
            'status' => 0,
            'taskDetail' => TaskDetail::with(['task.type'])->firstWhere('id', $request->id),
        ]);
    }

    public function show($id)
    {
        return view('admin.taskdetail.edit', [
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

    public function destroy($id)
    {
        try {
            TaskDetail::firstWhere('id', $id)->delete();

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

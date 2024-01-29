<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskDetail;
use App\Models\TaskItem;
use Illuminate\Http\Request;
use Throwable;

class TaskDetailController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'unit' => 'required|string',
            'kpi' => 'required|numeric',
            'task_id' => 'required|numeric',
            'item_id' => 'required|numeric',
        ]);
        try {
            TaskItem::create($data);
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
            'unit' => 'required|string',
            'kpi' => 'required|numeric',
            // 'task_id' => 'required|numeric',
            'item_id' => 'required|numeric',
        ]);
        unset($data['id']);
        try {
            TaskItem::where('id', $request->input('id'))->update($data);
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
        return view('admin.task.edit', [
            'title' => 'Chi tiết nhiệm vụ',
            'task' => Task::firstWhere('id', $id),
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
            TaskItem::firstWhere('id', $id)->delete();

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

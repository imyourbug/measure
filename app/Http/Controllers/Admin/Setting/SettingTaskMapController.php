<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\SettingTaskMap;
use Illuminate\Http\Request;

class SettingTaskMapController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'unit' => 'required|string',
            'kpi' => 'required|numeric',
            'task_id' => 'required|numeric',
            'map_id' => 'required|numeric',
        ]);
        try {
            SettingTaskMap::create($data);
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
            'result' => 'nullable|numeric',
            'image' => 'nullable|string',
            'detail' => 'nullable|string',
            'task_id' => 'required|numeric',
            'map_id' => 'required|numeric',
        ]);
        unset($data['id']);
        try {
            SettingTaskMap::where('id', $request->input('id'))->update($data);
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
        return response()->json([
            'status' => 0,
            'taskMaps' => SettingTaskMap::with(['task', 'map'])->where('task_id', $request->id)->get(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => 0,
            'taskMap' => SettingTaskMap::with(['task', 'map'])->firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            SettingTaskMap::firstWhere('id', $id)->delete();

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

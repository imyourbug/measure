<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Map;
use App\Models\SettingTaskMap;
use Illuminate\Http\Request;
use Throwable;

class SettingTaskMapController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'code' => 'nullable|string',
                'position' => 'nullable|string',
                'number' => 'required|numeric|min:1',
                'area' => 'required|string',
                'target' => 'nullable|string',
                'image' => 'nullable|string',
                'description' => 'nullable|string',
                'range' => 'nullable|string',
                'active' => 'required|in:0,1',
                'unit' => 'required|string',
                'kpi' => 'required|numeric',
                'fake_result' => 'nullable|numeric',
                'task_id' => 'required|numeric',
            ]);
            $number = (int)$data['number'];
            for ($i = 0; $i < $number; $i++) {
                $data['code'] = $data['area'] . '-' .
                    str_pad(((string)($i + 1)), 3, "0", STR_PAD_LEFT);;
                $dataInsert = [
                    'code' => $data['code'],
                    'area' => $data['area'],
                    'position' => $data['position'],
                    'target' => $data['target'],
                    'image' => $data['image'],
                    'description' => $data['description'],
                    'range' => $data['range'],
                    'active' => $data['active'],
                ];
                $map = Map::create($dataInsert);
                SettingTaskMap::create([
                    ...$dataInsert,
                    'unit' => $data['unit'],
                    'kpi' => $data['kpi'],
                    'task_id' => $data['task_id'],
                    'fake_result' => $data['fake_result'] ?? 0,
                    'map_id' => $map->id,
                ]);
            }
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
        try {
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

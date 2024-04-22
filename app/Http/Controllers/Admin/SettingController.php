<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TaskChemistry;
use App\Models\TaskDetail;
use App\Models\TaskItem;
use App\Models\TaskMap;
use App\Models\TaskSolution;
use App\Models\TaskStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Toastr;

class SettingController extends Controller
{
    public function uploadmap(Request $request)
    {
        $url = '';
        if ($request->hasFile('file')) {
            try {
                $file_name = date('H-i-s') . $request->file('file')->getClientOriginalName();
                $pathFull = 'uploads/' . date('Y-m-d');
                $request->file('file')->storeAs(
                    'public/' . $pathFull,
                    $file_name
                );
                $url = '/storage/' . $pathFull . '/' . $file_name;

                Setting::updateOrCreate(['key' => 'map'], [
                    'value' => $url
                ]);
            } catch (Throwable $e) {
                return response()->json([
                    'status' => 1,
                    'message' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'url' => $url
        ]);
    }

    public function backup(Request $request)
    {
        $email_or_phone = Auth::user()?->email ?? Auth::user()?->name;
        Log::info('Backup at ' . now()->format('Y-m-d H:i:s') . ' by ' . $email_or_phone);
        $filename = 'backup' . now()->format('Y-m-d') . '.sql';

        $disk = 'local';
        $path = 'public/backup';
        // Check if the folder exists
        if (!Storage::disk($disk)->exists($path)) {
            // Create the folder
            Storage::disk($disk)->makeDirectory($path);
        }
        $filePath = storage_path() . '/app/public/backup/' . $filename;
        $command = 'mysqldump --user=' . env('DB_USERNAME') . ' --password=' . env('DB_PASSWORD')
            . ' --host=' . env('DB_HOST') . ' --port=' . env('DB_PORT') . ' ' . env('DB_DATABASE') . ' > ' . $filePath;
        $returnVar = NULL;
        $output = NULL;
        // dd($command);
        exec($command, $output, $returnVar);
        Log::info('Command backup: ' . $command);

        return response()->download($filePath);
    }

    public function reload(Request $request)
    {
        $taskdetail_id = $request->taskdetail_id;
        try {
            DB::beginTransaction();
            $task_detail = TaskDetail::with([
                'task.settingTaskMaps',
                'task.settingTaskItems',
                'task.settingTaskSolutions',
                'task.settingTaskChemistries',
                'task.settingTaskStaffs',
                'taskMaps',
                'taskItems',
                'taskSolutions',
                'taskChemitries',
                'taskStaffs',
            ])
                ->firstWhere('id', $taskdetail_id);

            // taskMap
            $settingTaskMaps = $task_detail->task?->settingTaskMaps?->toArray() ?? [];
            $settingTaskMaps = array_map(function ($e) use ($taskdetail_id) {
                unset($e['id']);
                $e['task_id'] = (int)$taskdetail_id;
                return $e;
            }, $settingTaskMaps);
            TaskMap::upsert(
                $settingTaskMaps,
                ['map_id', 'task_id'],
                [
                    'code',
                    'area',
                    'position',
                    'target',
                    'unit',
                    'kpi',
                    'result',
                    'image',
                    'detail',
                    'round',
                    'fake_result',
                ]
            );
            // taskItem
            $settingTaskItems = $task_detail->task?->settingTaskItems?->toArray() ?? [];
            $settingTaskItems = array_map(function ($e) use ($taskdetail_id) {
                unset($e['id']);
                $e['task_id'] = (int)$taskdetail_id;
                return $e;
            }, $settingTaskItems);
            TaskItem::upsert(
                $settingTaskItems,
                ['item_id', 'task_id'],
                [
                    'code',
                    'name',
                    'unit',
                    'kpi',
                    'result',
                    'image',
                    'detail',
                ]
            );
            // taskSolution
            $settingTaskSolutions = $task_detail->task?->settingTaskSolutions?->toArray() ?? [];
            $settingTaskSolutions = array_map(function ($e) use ($taskdetail_id) {
                unset($e['id']);
                $e['task_id'] = (int)$taskdetail_id;
                return $e;
            }, $settingTaskSolutions);
            TaskSolution::upsert(
                $settingTaskSolutions,
                ['solution_id', 'task_id'],
                [
                    'code',
                    'name',
                    'unit',
                    'kpi',
                    'result',
                    'image',
                    'detail',
                ]
            );
            // taskStaff
            $settingTaskStaffs = $task_detail->task?->settingTaskStaffs?->toArray() ?? [];
            $settingTaskStaffs = array_map(function ($e) use ($taskdetail_id) {
                unset($e['id']);
                $e['task_id'] = (int)$taskdetail_id;
                return $e;
            }, $settingTaskStaffs);
            TaskStaff::upsert(
                $settingTaskStaffs,
                ['user_id', 'task_id'],
                [
                    'code',
                    'name',
                    'position',
                    'tel',
                    'identification',
                ]
            );
            // taskChemistry
            $settingTaskChemistries = $task_detail->task?->settingTaskChemistries?->toArray() ?? [];
            $settingTaskChemistries = array_map(function ($e) use ($taskdetail_id) {
                unset($e['id']);
                $e['task_id'] = (int)$taskdetail_id;
                return $e;
            }, $settingTaskChemistries);
            TaskChemistry::upsert(
                $settingTaskChemistries,
                ['chemistry_id', 'task_id'],
                [
                    'code',
                    'name',
                    'unit',
                    'kpi',
                    'result',
                    'image',
                    'detail',
                ]
            );
            DB::commit();
            Toastr::success('Tải lên cài đặt thành công', __('title.toastr.success'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            foreach ($request->except('_token') as $key => $value) {
                Setting::where('key', $key)->update([
                    'value' => $value
                ]);
            }
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error(__('message.fail.update'), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.setting', [
            'title' => 'Cài đặt',
            'settings' => Setting::all()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Constant\GlobalConstant;
use App\Models\TaskImage;
use App\Models\TaskItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        $url = '';
        try {
            $request->validate([
                // 'file' =>  'max:500000|mimes:jpeg,png,pdf,docx,pptx,cad,xlsx,xls,csv',
                'file' =>  'max:500000',
            ]);
            $file_name = time() . $request->file('file')->getClientOriginalName();
            $pathFull = 'upload';
            $request->file('file')->storeAs(
                'public/' . $pathFull,
                $file_name
            );
            $url = '/storage/' . $pathFull . '/' . $file_name;
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 0,
            'url' => $url
        ]);
    }

    public function uploadMultipleImages(Request $request)
    {
        try {
            $data = $request->validate([
                'files.*' =>  'max:500000',
                'files' =>  'nullable|array',
                'task_id' =>  'required|integer',
            ]);

            $images = [];
            foreach ($data['files'] as $file) {
                # code...
                $file_name = time() . $file->getClientOriginalName();
                $pathFull = 'upload/';
                $file->storeAs(
                    'public/' . $pathFull,
                    $file_name
                );
                $images[] =  TaskImage::create([
                    'task_id' => $data['task_id'],
                    'url' => '/storage/' . $pathFull . '/' . $file_name,
                ]);
            }
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 0,
            'images' => $images
        ]);
    }

    public function restore(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                if ($request->file('file')->getClientOriginalExtension() !== GlobalConstant::TYPE_FILE_BACKUP) {
                    throw new Exception('File không hợp lệ');
                }
                $file_name = time() . $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('public/restore', $file_name);
                $file_location = public_path() . '/storage/restore/' . $file_name;

                Log::info('file_location.' . $file_location);
                DB::unprepared(file_get_contents($file_location));
                Log::info('Database restore completed.');
            } catch (Throwable $e) {
                return response()->json([
                    'status' => 1,
                    'message' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'message' => 'Phục hồi dữ liệu thành công'
        ]);
    }

    public function deleteImage($id)
    {
        try {
            TaskImage::firstWhere('id', $id)->delete();

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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

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
}

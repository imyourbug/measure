<?php

namespace App\Http\Controllers;

use App\Mail\AlertMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendMail(Request $request)
    {
        $error_code = $request->error_code ?? '';
        $content = $request->content ?? '';
        $email = $request->email ?? 'duongvankhai2022001@gmail.com';
        $result = 0;
        $ip = $request->ip();
        try {
            $check = Cache::get($ip);
            if (!$check) {
                Mail::to($email)->send(new AlertMail($error_code, $content));
                Cache::set($ip, true, 300);
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            $result = 1;
        }

        return $result;
    }
}

<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Mail\RecoverPasswordMail;
use App\Models\InfoUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Toastr;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('user.task.list', [
            'title' => 'Trang người dùng',
        ]);
    }

    public function login()
    {
        return view('user.login.index', [
            'title' => 'Đăng nhập'
        ]);
    }

    public function forgot()
    {
        return view('user.forgot.index', [
            'title' => 'Quên mật khẩu'
        ]);
    }

    public function recover(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|regex:/^(.*?)@(.*?)$/'
            ]);
            if (!$user = User::firstWhere('email', $data['email'])) {
                Toastr::error('Email không tồn tại!', __('title.toastr.fail'));

                return redirect()->back();
            }
            $source = [
                'a', 'b', 'c', 'd', 'e', 'g', 1, 2, 3, 4, 5, 6
            ];
            $new_password = '';
            foreach ($source as $s) {
                $new_password .= $source[rand(0, count($source) - 1)];
            }
            $reset_password = $user->update([
                'password' => Hash::make($new_password)
            ]);
            if ($reset_password) {
                Mail::to($request->input('email'))->send(new RecoverPasswordMail($new_password));
            }
            Toastr::success('Lấy mật khẩu thành công! Hãy kiểm tra email của bạn', __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('users.login');
    }

    public function checkLogin(Request $request)
    {
        try {
            $tel_or_email = $request->tel_or_email;
            $validate = [
                'tel_or_email' => 'required|regex:/^(.*?)@(.*?)$/',
                'password' => 'required|string',
            ];
            if (is_numeric($tel_or_email)) {
                $validate['tel_or_email'] = 'required|string|regex:/^0\d{9,10}$/';
            }
            $request->validate($validate);
            if (Auth::attempt([
                is_numeric($tel_or_email) ? 'name' : 'email' => $tel_or_email,
                'password' => $request->input('password')
            ])) {
                Toastr::success('Đăng nhập thành công', __('title.toastr.success'));
                $user = Auth::user();

                return redirect()->route($user->role == 1 ? 'admin.index'
                    : ($user->role == 2 ? 'customers.me' : 'users.home'));
            } else {
                Toastr::error('Tài khoản hoặc mật khẩu không chính xác', __('title.toastr.fail'));
            }
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        try {
            $tel_or_email = $request->input('tel_or_email');
            $rules = [
                'tel_or_email' => 'required|regex:/^(.*?)@(.*?)$/',
                'old_password' => 'required|string',
                'password' => 'required|string',
            ];
            if (is_numeric($tel_or_email)) {
                $rules['tel_or_email'] = 'required|string|regex:/^0\d{9,10}$/';
            }
            $request->validate($rules);
            $type = is_numeric($tel_or_email) ? 'name' : 'email';
            $user = Auth::attempt([
                $type => $tel_or_email,
                'password' => $request->input('old_password')
            ]);
            if (!$user) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Mật khẩu cũ không chính xác'
                ]);
            }

            User::firstWhere($type, $tel_or_email)->update([
                'password' => Hash::make($request->input('password'))
            ]);

            return response()->json([
                'status' => 0,
                'message' => 'Đổi mật khẩu thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function register()
    {
        return view('user.register.index', [
            'title' => 'Đăng ký',
        ]);
    }

    public function checkRegister(Request $request)
    {
        try {
            $tel_or_email = $request->input('tel_or_email');
            $request->validate([
                'tel_or_email' => !is_numeric($tel_or_email) ? 'required|regex:/^(.*?)@(.*?)$/'
                    : 'required|string|regex:/^0\d{9,10}$/',
                'password' => 'required|string',
                'repassword' => 'required|string|same:password',
            ]);
            $check = User::where(is_numeric($tel_or_email) ? 'name' : 'email', $tel_or_email)
                ->get();
            if ($check->count() > 0) {
                Toastr::error('Tài khoản đã có người đăng ký!', __('title.toastr.fail'));

                return redirect()->back();
            }
            DB::beginTransaction();
            User::create([
                is_numeric($tel_or_email) ? 'name' : 'email' =>  $tel_or_email,
                'password' => Hash::make($request->input('password')),
                'role' => 1,
            ]);
            Toastr::success('Đăng ký thành công', __('title.toastr.success'));
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), __('title.toastr.fail'));

            return redirect()->back();
        }

        return redirect()->route('users.login');
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|int',
                'avatar' => 'required|string',
                'name' => 'required|string',
                'position' => 'required|string',
                'identification' => 'required|string|regex:/\d{12}$/',
                'tel' => 'required|string|regex:/^0\d{9,10}$/',
                'active' => 'required|in:0,1',
            ]);
            unset($data['id']);
            $update = InfoUser::where('id', $request->input('id'))->update($data);
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function me(Request $request)
    {
        return view('user.me', [
            'title' => 'Thông tin cá nhân',
            'staff' => User::with(['staff'])
                ->firstWhere('id', Auth::id())
                ->staff
        ]);
    }
}

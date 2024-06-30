<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InfoUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class AccountController extends Controller
{
    public function create()
    {
        return view('admin.account.add', [
            'title' => 'Thêm tài khoản'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $tel_or_email = $request->tel_or_email;
            $data = $request->validate([
                'tel_or_email' => !is_numeric($tel_or_email) ? 'required|regex:/^(.*?)@(.*?)$/'
                    : 'required|string|regex:/^0\d{9,10}$/',
                'password' => 'required|string',
                'role' => 'integer|in:0,1,2',
            ]);

            $check = User::where(is_numeric($tel_or_email) ? 'name' : 'email', $tel_or_email)
                ->get();
            if ($check->count() > 0) {
                throw new Exception('Tài khoản đã có người đăng ký!');
            }

            User::create([
                is_numeric($tel_or_email) ? 'name' : 'email' =>  $tel_or_email,
                'password' => Hash::make($data['password']),
                'role' => $data['role']
            ]);
            Toastr::success('Tạo tài khoản thành công', __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer',
                'password' => 'required|string',
                'role' => 'required|integer|in:0,1,2',
            ]);
            unset($data['id']);
            $data['password'] = Hash::make($data['password']);

            User::where('id', $request->input('id'))
                ->update($data);
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function getAll(Request $request)
    {
        return response()->json([
            'status' => 0,
            'accounts' => User::all()
        ]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => 0,
                'accounts' => User::all()->get()
            ]);
        }

        return view('admin.account.list', [
            'title' => 'Danh sách tài khoản',
        ]);
    }

    public function show($id)
    {
        return view('admin.account.edit', [
            'title' => 'Chi tiết tài khoản',
            'user' => User::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user = User::firstWhere('id', $id);
            $user->delete();
            DB::commit();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirTask;
use App\Models\Contract;
use App\Models\ElecTask;
use App\Models\InfoUser;
use App\Models\WaterTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.assignment.list', [
            'title' => 'Danh sách phân công',
            'electasks' => ElecTask::orderByDesc('created_at')->get(),
            'airtasks' => AirTask::orderByDesc('created_at')->get(),
            'watertasks' => WaterTask::orderByDesc('created_at')->get(),
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.assignment.add', [
            'title' => 'Phân công nhiệm vụ',
            'staffs' => InfoUser::with(['user'])->get(),
            'contracts' => Contract::with(['branch'])->get(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|numeric',
            'contract_id' => 'required|numeric',
            'type' => 'required|array',
        ]);
        try {
            DB::beginTransaction();
            foreach ($data['type'] as $type) {
                switch ((int)$type) {
                        // update electric task
                    case 0:
                        ElecTask::where('contract_id', $data['contract_id'])
                            ->update(['user_id' => $data['user_id']]);
                        break;
                        // update water task
                    case 1:
                        WaterTask::where('contract_id', $data['contract_id'])
                            ->update(['user_id' => $data['user_id']]);
                        break;
                        // update air task
                    case 2:
                        AirTask::where('contract_id', $data['contract_id'])
                            ->update(['user_id' => $data['user_id']]);
                        break;
                };
            }
            DB::commit();
            Toastr::success(__('message.success.update'), 'Thông báo');
        } catch (Throwable $th) {
            DB::rollBack();
            Toastr::error($th->getMessage(), 'Thông báo');
        }

        return redirect()->back();
    }
}

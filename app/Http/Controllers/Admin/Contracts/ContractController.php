<?php

namespace App\Http\Controllers\Admin\Contracts;

use App\Http\Controllers\Controller;
use App\Models\AirTask;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\ElecTask;
use App\Models\InfoUser;
use App\Models\User;
use App\Models\WaterTask;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;
use Toastr;

class ContractController extends Controller
{
    public function getTypeByContractId(Request $request)
    {
        $contract_id = $request->id;
        $response = [];
        if (ElecTask::where('contract_id', $contract_id)->get()->count() > 0) {
            $response[] = 0;
        }
        if (WaterTask::where('contract_id', $contract_id)->get()->count() > 0) {
            $response[] = 1;
        }
        if (AirTask::where('contract_id', $contract_id)->get()->count() > 0) {
            $response[] = 2;
        }

        return response()->json([
            'status' => 0,
            'data' => $response,
        ]);
    }

    public function create()
    {
        return view('admin.contract.add', [
            'title' => 'Thêm hợp đồng',
            'customers' => Customer::all(),
        ]);
    }

    public function getRangeTime($type, $arrValue, $start, $finish)
    {
        //
        $start = new DateTime($start);
        $finish = new DateTime($finish);
        $result = [];
        switch ($type) {
            case 'date':
                foreach ($arrValue as $value) {
                    switch ((int)$value) {
                        case 0:
                            for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1W'))) {
                                if (!in_array($date->format('Y-m-t'), $result)) {
                                    $result[] = $date->format('Y-m-t');
                                }
                            }
                            break;
                        default:
                            for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1D'))) {
                                if ($date->format('d') == $value) {
                                    $result[] = $date->format('Y-m-d');
                                }
                            }
                            break;
                    }
                };
                break;
            case 'day':
                foreach ($arrValue as $value) {
                    for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1D'))) {
                        $weekday = date('l', strtotime($date->format('Y-m-d')));
                        if ($weekday == $value) {
                            $result[] = $date->format('Y-m-d');
                        }
                    }
                };
                break;
        }

        return $result;
    }

    public function createTask($rangeTime, $taskType, $contractId)
    {
        $data = [];
        foreach ($rangeTime as $time) {
            $data[] = [
                'plan_date' => $time,
                'contract_id' => $contractId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        };
        if (count($data) > 0) {
            dispatch(function () use ($data, $taskType) {
                $taskType == 0 ?  ElecTask::insert($data) : ($taskType == 1 ?
                    WaterTask::insert($data) :  AirTask::insert($data));
            });
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'customer_id' => 'required|numeric',
                'start' => 'required|date',
                'finish' => 'required|date',
                'content' => 'required|string',
                'attachment' => 'nullable|string',
                // 0 - elec, 1 - water, 2 - air
                'data' => 'nullable|array',
                'data.*.branch_id' => 'nullable|numeric',
                'data.*.task_type.*' => 'nullable|in:0,1,2',
                'data.*.type_elec' => 'nullable|in:date,day',
                'data.*.value_elec' => 'nullable',
                'data.*.type_water' => 'nullable|in:date,day',
                'data.*.value_water' => 'nullable',
                'data.*.type_air' => 'nullable|in:date,day',
                'data.*.value_air' => 'nullable',
            ]);

            DB::beginTransaction();
            if (!empty($data['data'])) {
                foreach ($data['data'] as $item) {
                    $contract = Contract::create([
                        'name' =>  $data['name'],
                        'customer_id' =>  $data['customer_id'],
                        'start' =>  $data['start'],
                        'finish' =>  $data['finish'],
                        'content' =>  $data['content'],
                        'attachment' =>  $data['attachment'],
                        'branch_id' =>  $item['branch_id'],
                    ]);
                    if (!empty($item['task_type'])) {
                        foreach ($item['task_type'] as $type) {
                            $rangeTime = [];
                            switch (true) {
                                    // create electric task
                                case 0 === (int)$type && !empty($item['value_elec']):
                                    $rangeTime = $this->getRangeTime($item['type_elec'], $item['value_elec'], $data['start'], $data['finish']);
                                    break;
                                    // create water task
                                case 1 === (int)$type && !empty($item['value_water']):
                                    $rangeTime = $this->getRangeTime($item['type_water'], $item['value_water'], $data['start'], $data['finish']);
                                    break;
                                    // create air task
                                case 2 === (int)$type && !empty($item['value_air']):
                                    $rangeTime = $this->getRangeTime($item['type_air'], $item['value_air'], $data['start'], $data['finish']);
                                    break;
                            };
                            $this->createTask($rangeTime, $type, $contract->id);
                        }
                    }
                }
            }
            DB::commit();

            return [
                'status' => 0,
                'message' => 'Tạo hợp đồng thành công'
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());

            return [
                'status' => 1,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|numeric',
            'id' => 'required|numeric',
            'start' => 'required|date',
            'finish' => 'required|date',
            'content' => 'required|string',
            'attachment' => 'nullable|string',
            'name' => 'required|string',
        ]);
        unset($data['id']);
        $update = Contract::firstWhere('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), 'Thông báo');
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function delete($id)
    {
        $delete = Contract::firstWhere('id', $id)->delete();
        if ($delete) {
            Toastr::success(__('message.success.delete'), 'Thông báo');
        } else Toastr::error(__('message.fail.delete'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index(Request $request)
    {
        return view('admin.contract.list', [
            'title' => 'Danh sách hợp đồng',
            'contracts' => Contract::with('customer')->get(),
        ]);
    }

    public function show($id)
    {
        return view('admin.contract.edit', [
            'title' => 'Cập nhật hợp đồng',
            'contract' => Contract::with(['elecTasks', 'waterTasks', 'airTasks'])->firstWhere('id', $id),
            'customers' => Customer::all(),
        ]);
    }

    public function detail($id)
    {
        return view('admin.contract.detail', [
            'title' => 'Chi tiết hợp đồng',
            'contract' => Contract::with(['elecTasks', 'waterTasks', 'airTasks'])->firstWhere('id', $id),
            'customers' => Customer::all(),
        ]);
    }

    public function destroy($id)
    {
        try {
            Contract::firstWhere('id', $id)->delete();

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

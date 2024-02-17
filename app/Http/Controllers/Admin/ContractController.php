<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Models\Type;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class ContractController extends Controller
{
    public function create()
    {
        return view('admin.contract.add', [
            'title' => 'Thêm hợp đồng',
            'customers' => Customer::all(),
            'parent_types' => Type::where('parent_id', 0)
                ->get(),
        ]);
    }

    public function getRangeTime($type, $arrValue, $start, $finish)
    {
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
        $task = Task::create([
            'type_id' => $taskType,
            'contract_id' => $contractId,
        ]);
        foreach ($rangeTime as $time) {
            $data[] = [
                'plan_date' => $time,
                'task_id' => $task->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        };
        if (count($data) > 0) {
            TaskDetail::insert($data);
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
                'data' => 'nullable|array',
                'data.*.branch_id' => 'nullable|numeric',
                'data.*.info_tasks.*' => 'nullable|array',
                'data.*.info_tasks.*.task_type' => 'nullable|numeric',
                'data.*.info_tasks.*.time_type' => 'nullable|string|in:date,day',
                'data.*.info_tasks.*.value_time_type' => 'nullable|array',
                'data.*.info_tasks.*.value_time_type.*' => 'nullable',
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
                    if (!empty($item['info_tasks'])) {
                        foreach ($item['info_tasks'] as $info) {
                            $rangeTime = $this->getRangeTime($info['time_type'], $info['value_time_type'], $data['start'], $data['finish']);
                            $this->createTask($rangeTime, $info['task_type'], $contract->id);
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
            Toastr::success(__('message.success.update'), __('title.toastr.fail'));
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function delete($id)
    {
        $delete = Contract::firstWhere('id', $id)->delete();
        if ($delete) {
            Toastr::success(__('message.success.delete'), __('title.toastr.fail'));
        } else Toastr::error(__('message.fail.delete'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => 0,
                'contracts' => Contract::with(['customer', 'branch'])->get()
            ]);
        }

        return view('admin.contract.list', [
            'title' => 'Danh sách hợp đồng',
            'contracts' => Contract::with('customer')->get(),
        ]);
    }

    public function show($id)
    {
        return view('admin.contract.edit', [
            'title' => 'Cập nhật hợp đồng',
            'contract' => Contract::with(['tasks'])->firstWhere('id', $id),
            'customers' => Customer::all(),
        ]);
    }

    public function detail($id)
    {
        return view('admin.contract.detail', [
            'title' => 'Chi tiết hợp đồng',
            'contract' => Contract::with([
                'tasks.details', 'tasks.type',
            ])->firstWhere('id', $id),
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

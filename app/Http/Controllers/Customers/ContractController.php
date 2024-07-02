<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\InfoUser;
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
    public function getAll(Request $request)
    {
        $customer_id = $request->customer_id;
        $month = $request->month;
        $contracts = Contract::with(['customer', 'branch', 'tasks.details'])
            ->when($customer_id, function ($q) use ($customer_id) {
                return $q->whereHas('customer', function ($q) use ($customer_id) {
                    $q->where('id', $customer_id);
                });
            })
            ->when($month, function ($q) use ($month) {
                return $q->whereHas('tasks.details', function ($q) use ($month) {
                    $q->whereRaw('MONTH(plan_date) = ?', $month);
                });
            })
            ->get();
        return response()->json([
            'status' => 0,
            'contracts' => $contracts
        ]);
    }

    public function index(Request $request)
    {
        return view('customer.contract.list', [
            'title' => 'Danh sách hợp đồng',
            'contracts' => Contract::with('customer')->get(),
            'customers' => Customer::all(),
            'parent_types' => Type::where('parent_id', 0)
                ->get(),
        ]);
    }

    public function detail($id)
    {
        return view('customer.contract.detail', [
            'title' => 'Chi tiết hợp đồng',
            'contract' => Contract::with([
                'tasks.details', 'tasks.type',
            ])
                ->firstWhere('id', $id),
            'customers' => Customer::all(),
            'staff' => InfoUser::all(),
            'types' => Type::all(),
            'contracts' => Contract::with(['branch'])
                ->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\TaskDetail;
use App\Models\TaskMap;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MPDF;

class ExportController extends Controller
{
    //
    public function plan(Request $request)
    {
        $data = $request->validate([
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|min:1900',
            'type_report' => 'required|in:0,1',
            'contract_id' => 'required|numeric',
            'image_charts' => 'nullable|array',
            'user_id' => 'required|numeric',
        ]);
        $data['creator'] = User::with(['staff'])->firstWhere('id', $data['user_id'])->toArray();
        $pdf = null;
        $filename = '';
        // dd($this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id']));
        switch ((int)$data['type_report']) {
            case 0:
                $pdf = MPDF::loadView('pdf.report_plan', ['data' => $data
                    + $this->getReportPlanByMonthAndYear($data['month'], $data['year'], $data['contract_id'])]);
                $filename = 'Báo cáo kế hoạch ';
                break;
            case 1:
                $pdf = MPDF::loadView('pdf.report_result', ['data' =>
                $data
                    + $this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id'])]);
                $filename = 'Báo cáo kết quả ';
                break;
            default:
                break;
        }
        // $pdf->setPaper('A4', 'portrait');
        $filename .= 'tháng ' . $data['month'] . ' năm ' . $data['year'] . '.pdf';

        return $pdf->stream($filename);
        return $pdf->download($filename);
    }

    public function getReportPlanByMonthAndYear($month, $year, $contract_id)
    {
        return Contract::with([
            'customer',
            'branch',
            'tasks.type.parent',
            'tasks.details.taskMaps.map',
            'tasks.details.taskItems.item',
            'tasks.details.taskSolutions.solution',
            'tasks.details.taskChemitries.chemistry',
            'tasks.details.taskStaffs.user.staff',
        ])
            ->where('id', $contract_id)
            ->whereHas('tasks.details', function ($q) use ($month, $year) {
                $q->whereRaw('year(plan_date) = ?', $year)
                    ->whereRaw('month(plan_date) = ?', $month);
            })
            ->first()
            ?->toArray() ?? [];
    }

    public function getReportWorkByMonthAndYear($month, $year, $contract_id)
    {
        return Contract::with([
            'customer',
            'branch',
            'tasks.type.parent',
            'tasks.details.taskMaps.map',
            'tasks.details.taskItems.item',
            'tasks.details.taskSolutions.solution',
            'tasks.details.taskChemitries.chemistry',
            'tasks.details.taskStaffs.user.staff',
        ])
            ->where('id', $contract_id)
            ->whereHas('tasks.details', function ($q) use ($month, $year) {
                $q->whereRaw('YEAR(plan_date) = ?', $year)
                    ->whereRaw('MONTH(plan_date) = ?', $month);
            })
            ->first()
            ?->toArray() ?? [];
    }

    public function getDataMapChart(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $contract_id = $request->contract_id;

        $task_details = TaskDetail::with(['task', 'taskMaps.map'])
            ->whereRaw('MONTH(plan_date) = ?', $month)
            ->whereRaw('YEAR(plan_date) = ?', $year)
            ->whereHas('task', function ($q) use ($contract_id) {
                $q->where('contract_id', $contract_id);
            })
            ->get();
        // dd(array_unique($task_details->pluck('task_id')?->toArray() ?? []));
        $result = [];
        foreach ($task_details as $key => $task_detail) {
            DB::enableQueryLog();
            $data_map = DB::table('task_maps')
                ->selectRaw('map_id, maps.area as area,
            SUM(CASE
                WHEN kpi is NULL THEN 0
                WHEN kpi = "" THEN 0
                ELSE kpi
            END) as all_kpi,
            SUM(CASE
                WHEN result is NULL THEN 0
                WHEN result = "" THEN 0
                ELSE result
            END) as all_result')
                ->join('maps', 'maps.id', '=', 'task_maps.map_id')
                // ->join('task_details', function(JoinClause $join) {
                //     $join->on('task')
                // })
                ->whereRaw('task_id = ?', $task_detail->id)
                ->groupByRaw('map_id, area')
                ->orderBy('map_id')
                ->get()
                ?->toArray() ?? [];
            foreach ($data_map as $key => $data) {
                $data = (array)$data;
                if (isset($result[$task_detail->task->id][$data['map_id']])) {
                    $result[$task_detail->task->id][$data['map_id']]['all_kpi'] += $data['all_kpi'];
                    $result[$task_detail->task->id][$data['map_id']]['all_result'] += $data['all_result'];
                } else {
                    $result[$task_detail->task->id][$data['map_id']] = $data;
                }
            }
            $result[$task_detail->task->id]['task_id'] = $task_detail->task->id;
        }

        return [
            'status' => 0,
            'data' => $result,
        ];
    }
}

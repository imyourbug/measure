<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\TaskMap;
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
        ]);
        $pdf = null;
        $filename = '';
        // dd($data + $this->getReportPlanByMonthAndYear($data['month'], $data['year'], $data['contract_id']));
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
            'tasks.type',
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
            'tasks.type',
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

    public function getDataMapChart(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $contract_id = $request->contract_id;

        // DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        dd($month, $year,TaskMap::with(['task.task.contract'])
            ->selectRaw('map_id, SUM(kpi) as all_kpi, SUM(result) as all_result')
            ->whereHas('task.task.contract', function ($q) use ($contract_id) {
                $q->where('id', $contract_id);
            })
            ->whereHas('task', function ($q) use ($month, $year) {
                $q->whereRaw('MONTH(plan_date) = ?', $month)
                    ->whereRaw('YEAR(plan_date) = ?', $year);
            })
            ->groupByRaw('map_id')
            ->orderBy('map_id')
            ->toSql());
        $result = TaskMap::with(['task.task.contract'])
            ->selectRaw('map_id, SUM(kpi) as all_kpi, SUM(result) as all_result')
            ->whereHas('task.task.contract', function ($q) use ($contract_id) {
                $q->where('id', $contract_id);
            })
            ->whereHas('task', function ($q) use ($month, $year) {
                $q->whereRaw('MONTH(plan_date) = ?', $month)
                    ->whereRaw('YEAR(plan_date) = ?', $year);
            })
            ->groupByRaw('map_id')
            ->orderBy('map_id')
            ->get()
            ?->toArray() ?? [];

        return [
            'status' => 0,
            'data' => $result,
        ];
    }
}

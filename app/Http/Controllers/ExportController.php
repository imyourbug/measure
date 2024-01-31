<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use PDF;

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
                $pdf = PDF::loadView('pdf.report_plan', ['data' => $data
                    + $this->getReportPlanByMonthAndYear($data['month'], $data['year'], $data['contract_id'])]);
                $filename = 'Báo cáo kế hoạch ';
                break;
            case 1:
                $pdf = PDF::loadView('pdf.report_result', ['data' => $data]);
                $filename = 'Báo cáo kết quả ';
                break;
            default:
                break;
        }
        $pdf->setPaper('A4', 'portrait');
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
}

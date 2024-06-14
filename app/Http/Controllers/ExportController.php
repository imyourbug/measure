<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Setting;
use App\Models\TaskDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use MPDF;
use Throwable;

class ExportController extends Controller
{

    public function dowload(Request $request)
    {
        $filename = $request->filename ?? '';
        if ($filename) {
            return response()->file(
                $filename
            );
        }
    }

    public function plan(Request $request)
    {
        try {
            ini_set('max_execution_time', '300');
            ini_set("pcre.backtrack_limit", "5000000");

            $data = $request->validate([
                'month' => 'required|numeric|between:1,12',
                'year' => 'required|numeric|min:1900',
                'year_compare' => 'required|numeric|min:1900',
                'month_compare' => 'required|numeric|between:1,12',
                'type_report' => 'required|in:0,1,2,3,4,5,6',
                'contract_id' => 'required|numeric',
                'image_charts' => 'nullable|array',
                'image_trend_charts' => 'nullable|array',
                'image_annual_charts' => 'nullable|array',
                'user_id' => 'nullable|numeric',
                'display' => 'required|in:0,1',
                'display_first' => 'required|in:0,1',
                'display_second' => 'required|in:0,1',
                'display_third' => 'required|in:0,1',
                //
                'display_year' => 'required|in:0,1',
                'display_month_compare' => 'required|in:0,1',
                'display_year_compare' => 'required|in:0,1',
            ]);

            $data['creator'] = User::with(['staff'])->firstWhere('id', $data['user_id'])?->toArray() ?? [];
            $data['setting'] = [];
            $settings = Setting::orderBy('key')->get()?->toArray() ?? [];
            foreach ($settings as $key => $setting) {
                $data['setting'][$setting['key']] = $setting['value'];
            }
            $pdf = null;
            $filename = '';
            switch ((int)$data['type_report']) {
                case 0:
                    $data['file_name'] = $filename = 'KẾ HOẠCH THỰC HIỆN DỊCH VỤ ';
                    $pdf = MPDF::loadView('pdf.report_plan_0', ['data' => array_merge($data, $this->getReportPlanByMonthAndYear($data['month'], $data['year'], $data['contract_id']))]);
                    break;
                case 1:
                    $data['file_name'] = $filename = 'KẾ HOẠCH CHI TIẾT ';
                    $pdf = MPDF::loadView('pdf.report_plan_1', ['data' => array_merge($data, $this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id']))]);
                    break;
                case 2:
                    $data['file_name'] = $filename = 'BÁO CÁO ĐÁNH GIÁ KẾT QUẢ THỰC HIỆN DỊCH VỤ ';
                    $pdf = MPDF::loadView('pdf.report_plan_2', ['data' => array_merge($data, $this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id']))]);
                    break;
                case 3:
                    $data['file_name'] = $filename = 'BIÊN BẢN NGHIỆM THU CÔNG VIỆC HOÀN THÀNH ';
                    $pdf = MPDF::loadView('pdf.report_plan_3', ['data' => array_merge($data, $this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id']))]);
                    break;
                case 4:
                    $data['file_name'] = $filename = 'BIÊN BẢN XÁC NHẬN KHỐI LƯỢNG HOÀN THÀNH-BÁO CÁO CHI TIẾT ';
                    $pdf = MPDF::loadView('pdf.report_plan_4', [
                        'data' =>
                        $data +
                            ['compare' => $this->getDataCompareTwoYears($data['year'], $data['year_compare'], $data['contract_id'])] +
                            $this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id'])
                    ]);
                    break;
                case 5:
                    $data['file_name'] = $filename = 'BẢNG KÊ CÔNG VIỆC/DỊCH VỤ ';
                    $pdf = MPDF::loadView('pdf.report_plan_5', ['data' => array_merge($data, $this->getReportPlanByMonthAndYear($data['month'], $data['year'], $data['contract_id']))]);
                    break;
                case 6:
                    //  dd(
                    //     ['data' => array_merge($data, $this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id']))]
                    // );
                    $data['file_name'] = $filename = 'BIÊN BẢN XÁC NHẬN CÔNG VIỆC/DỊCH VỤ ';
                    $pdf = MPDF::loadView('pdf.report_plan_6', ['data' => array_merge($data, $this->getReportWorkByMonthAndYear($data['month'], $data['year'], $data['contract_id']))]);
                    break;
                default:
                    break;
            }
            $filename .= 'tháng ' . $data['month'] . ' năm ' . $data['year'];
            $filename = Str::slug($filename) . '.pdf';

            $path = storage_path() . '/app/public/pdf/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $pdf->save($path . $filename, 'F');

            return response()->json([
                'status' => 0,
                'url' => '/storage/pdf/' . $filename
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getReportPlanByMonthAndYear($month, $year, $contract_id)
    {
        $contract = Contract::with([
            'customer',
            'branch',
            'tasks.type.parent',
            'tasks.details.taskMaps.map',
            'tasks.details.taskItems.item',
            'tasks.details.taskSolutions.solution',
            'tasks.details.taskChemitries.chemistry',
            'tasks.details.taskStaffs.user.staff',
            'tasks.settingTaskMaps.map',
            'tasks.settingTaskChemistries.chemistry',
            'tasks.settingTaskSolutions.solution',
            'tasks.settingTaskItems.item',
            'tasks.settingTaskStaffs.user.staff',
        ])
            ->where('id', $contract_id)
            ->first()
            ->toArray();
        $tasks = $contract['tasks'];
        $result = [];
        $result['contract'] = $contract;
        $result['customer'] = $contract['customer'];
        $result['branch'] = $contract['branch'];
        foreach ($tasks as $task) {
            $tmp = [];
            foreach ($task['details'] as $detail) {
                $date = explode('-', $detail['plan_date']);
                if ((int)$date[0] === (int)$year && (int)$date[1] === (int)$month) {
                    $tmp[] = $detail;
                }
            }
            unset($task['details']);
            $result['tasks'][] = [
                'details' => $tmp,
                ...$task,
            ];
        }

        return $result;
    }

    public function getReportWorkByMonthAndYear($month, $year, $contract_id)
    {
        $contract = Contract::with([
            'customer',
            'branch',
            'tasks.type.parent',
            'tasks.details.taskMaps.map',
            'tasks.details.taskItems.item',
            'tasks.details.taskSolutions.solution',
            'tasks.details.taskChemitries.chemistry',
            'tasks.details.taskStaffs.user.staff',
            'tasks.settingTaskMaps.map',
            'tasks.settingTaskChemistries.chemistry',
            'tasks.settingTaskSolutions.solution',
            'tasks.settingTaskItems.item',
            'tasks.settingTaskStaffs.user.staff',
        ])
            ->where('id', $contract_id)
            ->first()
            ->toArray();
        $tasks = $contract['tasks'];
        $result = [];
        $result['contract'] = $contract;
        $result['customer'] = $contract['customer'];
        $result['branch'] = $contract['branch'];
        foreach ($tasks as $task) {
            $tmp = [];
            foreach ($task['details'] as $detail) {
                $date = explode('-', $detail['plan_date']);
                if ((int)$date[0] === (int)$year && (int)$date[1] === (int)$month) {
                    $tmp[] = $detail;
                }
            }
            unset($task['details']);
            $result['tasks'][] = [
                'details' => $tmp,
                ...$task,
            ];
        }

        foreach ($result['tasks'] as $key => &$task) {
            $tmp = [];
            foreach ($task['details'] as $keyDetail => &$detail) {
                foreach ($detail['task_maps'] as $keyTaskMap => &$taskMap) {
                    $mapCode = explode('-', $taskMap['code']);
                    if (!empty($tmp[$task['id']][$mapCode[0]][$taskMap['code']])) {
                        $taskMap['result'] = ($tmp[$task['id']][$mapCode[0]][$taskMap['code']]['result'] ?? 0) + ($taskMap['result'] ?? 0);
                        $taskMap['kpi'] = ($tmp[$task['id']][$mapCode[0]][$taskMap['code']]['kpi'] ?? 0) + ($taskMap['kpi'] ?? 0);
                    }
                    $tmp[$task['id']][$mapCode[0]][$taskMap['code']] = $taskMap;
                }
            }
            $detail['task_maps'] = $tmp;
            $task['group_details'] = $tmp;
        }
        // dd($result);

        return $result;
    }

    public function getDataMapChart(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $contract_id = $request->contract_id;

        try {
            $task_details = TaskDetail::with(['task', 'taskMaps.map'])
                ->whereRaw('MONTH(plan_date) = ?', $month)
                ->whereRaw('YEAR(plan_date) = ?', $year)
                ->whereHas('task', function ($q) use ($contract_id) {
                    $q->where('contract_id', $contract_id);
                })
                ->get();
            $result = [];
            foreach ($task_details as $key => $task_detail) {
                DB::enableQueryLog();
                $data_map = DB::table('task_maps')
                    ->selectRaw('map_id, maps.code as code,
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
                    ->whereRaw('task_id = ?', $task_detail->id)
                    ->groupByRaw('map_id, code')
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

            foreach ($result as $key => &$rs) {
                $tmp = [];
                foreach ($rs as $keyRs => $valueRs) {
                    if (is_numeric($keyRs)) {
                        $mapCode = explode('-', $valueRs['code']);
                        $tmp[$mapCode[0]][$valueRs['map_id']] = $valueRs;
                    }
                }
                $tmpTaskId = $rs['task_id'];
                $rs = $tmp;
                $rs['task_id'] = $tmpTaskId;
            }
        } catch (Throwable $e) {
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 0,
            'data' => $result,
        ]);
    }

    public function getDataAnnualMapChart(Request $request)
    {
        $contract_id = $request->contract_id;
        $year = $request->year;

        $contract = Contract::with(['tasks.details'])->firstWhere('id', $contract_id);

        $result = [];
        $code = [];
        foreach ($contract->tasks as $task) {
            $details = TaskDetail::with(['task', 'taskMaps.map'])
                ->whereRaw('YEAR(plan_date) = ?', $year)
                ->where('task_id', $task->id)
                ->get();
            // get code
            foreach ($details as $detail) {
                foreach ($detail['taskMaps'] as $taskMap) {
                    $mapCode = explode('-', $taskMap->code);
                    $code[$mapCode[0]] = $mapCode[0];
                }
            }
        }

        DB::unprepared("DROP FUNCTION IF EXISTS SPLIT_STRING;
        CREATE FUNCTION SPLIT_STRING(str VARCHAR(255), delim VARCHAR(12), pos INT)
        RETURNS VARCHAR(255)
        RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(str, delim, pos),
            CHAR_LENGTH(SUBSTRING_INDEX(str, delim, pos-1)) + 1),
            delim, '');");
        foreach ($contract->tasks as $task) {
            $tmp = [];
            for ($month = 1; $month <= 12; $month++) {
                $details = TaskDetail::with(['task', 'taskMaps.map'])
                    ->whereRaw('MONTH(plan_date) = ?', $month)
                    ->whereRaw('YEAR(plan_date) = ?', $year)
                    ->where('task_id', $task->id)
                    ->get();
                // get key
                $key_task_details = $details->pluck('id');
                // get value
                foreach ($code as $c) {
                    $value = DB::table('task_maps')
                        ->selectRaw('SUM(CASE
                                    WHEN kpi is NULL THEN 0
                                    WHEN kpi = "" THEN 0
                                    ELSE kpi
                                END) as all_kpi,
                                SUM(CASE
                                    WHEN result is NULL THEN 0
                                    WHEN result = "" THEN 0
                                    ELSE result
                                END) as all_result')
                        ->whereIn('task_id', $key_task_details)
                        ->whereRaw('SPLIT_STRING(code, "-", 1) = ?', $c)
                        ->first();

                    $tmp[$month][$c] = [
                        'kpi' => $value->all_kpi ?? 0,
                        'result' => $value->all_result ?? 0,
                        'code' => $c,
                        'month' => $month,
                    ];
                }
            }
            $result[$task->id] = [
                'value' => collect($tmp)->values(),
                'task_id' => $task->id
            ];
        }

        return response()->json([
            'status' => 0,
            'data' => $result,
        ]);
    }

    public function getTrendDataMapChart(Request $request)
    {
        $year = $request->year;
        $year_compare = $request->year_compare;
        $month = $request->month;
        $month_compare = $request->month_compare;
        $contract = Contract::with(['tasks.details'])->firstWhere('id', $request->contract_id);
        $tmpResult = [];
        foreach ($contract->tasks as $task) {
            $tmp_this_year = [];
            $tmp_last_year = [];
            $tmp_this_year = $this->getDataTrend($month, $year, $task->id);
            $tmp_last_year = $this->getDataTrend($month_compare, $year_compare, $task->id);
            $tmpResult[$task->id] = [
                'task_id' => $task->id,
                'last_year' => $tmp_last_year,
                'this_year' => $tmp_this_year,
            ];
        }
        // get all code
        $result = [];
        foreach ($tmpResult as $key => $valueTmp) {
            foreach ($valueTmp['last_year'] as $keyLastYear => $valueLastYear) {
                if (!in_array($key . $keyLastYear, $result)) {
                    $result[$key . $keyLastYear]['last_year'] = $valueLastYear['kpi'] != 0 ?
                        ($valueLastYear['result'] / $valueLastYear['kpi']) * 100 : 0;
                    $result[$key . $keyLastYear]['task_id'] = $key;
                }
            }
            foreach ($valueTmp['this_year'] as $keyThisYear => $valueThisYear) {
                if (!in_array($key . $keyThisYear, $result)) {
                    $result[$key . $keyThisYear]['this_year'] = $valueThisYear['kpi'] != 0 ?
                        ($valueThisYear['result'] / $valueThisYear['kpi']) * 100 : 0;
                    $result[$key . $keyThisYear]['task_id'] = $key;
                }
            }
        }

        $result = array_map(function ($key, $item) {
            return [
                'last_year' => $item['last_year'] ?? 0,
                'this_year' => $item['this_year'] ?? 0,
                'code' => $key,
                'task_id' =>  $item['task_id'] ?? '',
            ];
        }, array_keys($result), array_values($result));

        return response()->json([
            'status' => 0,
            'data' => $result,
        ]);
    }

    public function getDataTrend($month, $year, $task_id)
    {
        $details = TaskDetail::with(['task', 'taskMaps.map'])
            ->whereRaw('MONTH(plan_date) = ?', $month)
            ->whereRaw('YEAR(plan_date) = ?', $year)
            ->where('task_id',  $task_id)
            ->get()
            ?->toArray() ?? [];

        $result = [];
        foreach ($details as $keyDetail => $detail) {
            if (!empty($detail['task_maps'])) {
                foreach ($detail['task_maps'] as $keyTaskMap => $taskMap) {
                    $mapCode = explode('-', $taskMap['code']);

                    $result[$mapCode[0]]['result'] = ($result[$mapCode[0]]['result'] ?? 0) +  ($taskMap['result'] ?? 0);
                    $result[$mapCode[0]]['kpi'] = ($result[$mapCode[0]]['kpi'] ?? 0) +  ($taskMap['kpi'] ?? 0);
                    $result[$mapCode[0]]['code'] = $mapCode[0];
                }
            }
        }

        return $result;
    }

    public function getDataByMonthAndYear($month, $year, $task_id)
    {
        $details = TaskDetail::with(['task', 'taskMaps.map'])
            ->whereRaw('MONTH(plan_date) = ?', $month)
            ->whereRaw('YEAR(plan_date) = ?', $year)
            ->where('task_id',  $task_id)
            ->get()
            ?->toArray() ?? [];

        $result = [];
        foreach ($details as $keyDetail => $detail) {
            if (!empty($detail['task_maps'])) {
                foreach ($detail['task_maps'] as $keyTaskMap => $taskMap) {
                    $mapCode = explode('-', $taskMap['code']);

                    $result[$mapCode[0]]['result'] = ($result[$mapCode[0]]['result'] ?? 0) +  ($taskMap['result'] ?? 0);
                    $result[$mapCode[0]]['kpi'] = ($result[$mapCode[0]]['kpi'] ?? 0) +  ($taskMap['kpi'] ?? 0);
                    $result[$mapCode[0]]['code'] = $mapCode[0];
                }
            }
        }

        return $result;
    }

    public function getDataCompareTwoYears($firstYear, $secondYear, $contractId)
    {
        $contract = Contract::with(['tasks.details'])->firstWhere('id', $contractId);
        $result = [];
        foreach ($contract->tasks as $task) {
            $tmp_this_year = [];
            $tmp_last_year = [];
            for ($month = 1; $month <= 12; $month++) {
                $tmp_this_year[$month] = $this->getDataCompareByMonthYearTaskId($month, $firstYear, $task->id);
                $tmp_last_year[$month] = $firstYear == $secondYear ? $tmp_this_year[$month] :
                    $this->getDataCompareByMonthYearTaskId($month, $secondYear, $task->id);
            }
            $result[$task->id] = [
                'task_id' => $task->id,
                'last_year' => [
                    ...$tmp_last_year,
                    'year' => $secondYear
                ],
                'this_year' => [
                    ...$tmp_this_year,
                    'year' => $firstYear
                ],
            ];
        }

        return $result;
    }

    public function getDataCompareByMonthYearTaskId($month = 0, $year = 0, $task_id)
    {
        $details = TaskDetail::with([
            'task',
            'taskMaps.map',
            'taskItems.item',
            'taskSolutions.solution',
            'taskChemitries.chemistry',
            'taskStaffs.user.staff',
        ])
            ->whereRaw('MONTH(plan_date) = ?', $month)
            ->whereRaw('YEAR(plan_date) = ?', $year)
            ->where('task_id', $task_id)
            ->get()
            ->toArray();

        foreach ($details as $keyDetail => &$detail) {
            $tmp = [];
            foreach ($detail['task_maps'] as $keyTaskMap => $taskMap) {
                $mapCode = explode('-', $taskMap['code']);

                $tmp[$mapCode[0]][] = $taskMap;
            }
            $detail['task_maps'] = $tmp;
        }

        return $details;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        $today = Carbon::now();
        $today = $today->toDateString();
        $countRequest = ModelsRequest::whereDate('created_at', $today)
            ->whereNotNull('user_id')
            ->count();
        $countContract = Contract::whereDate('created_at', $today)->count();
        $countUniqueRequest = ModelsRequest::whereDate('created_at', $today)
            ->whereNull('user_id')
            ->count();

        if ($request->ajax()) {
            $dataRequestInMonth = array();
            $dataCancelRequestInMonth = array();
            $dataDays = array();

            $month = date('m');
            $year = date('Y');
            $numberDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $requestsInMonth = ModelsRequest::whereMonth('created_at', $month)
                ->get()
                ->groupBy(function ($data) {
                    return Carbon::parse($data->created_at)->format('d');
                });
            for ($i = 1; $i <= $numberDays; $i++) {
                $count = 0;
                foreach ($requestsInMonth as $requestInMonth => $value) {
                    if ($i == $requestInMonth) {
                        $count = count($value);
                        break;
                    }
                }
                array_push($dataRequestInMonth, $count);
                array_push($dataDays, $i);
            }

            $cancelRequestsInMonth = ModelsRequest::onlyTrashed()
                ->whereMonth('created_at', $month)
                ->get()
                ->groupBy(function ($data) {
                    return Carbon::parse($data->created_at)->format('d');
                });
            for ($i = 1; $i <= $numberDays; $i++) {
                $count = 0;
                foreach ($cancelRequestsInMonth as $cancelRequestInMonth => $value) {
                    if ($i == $cancelRequestInMonth) {
                        $count = count($value);
                        break;
                    }
                }
                array_push($dataCancelRequestInMonth, $count);
            }

            $data = [
                $dataDays,
                $dataRequestInMonth,
                $dataCancelRequestInMonth,
            ];
            return response()->json($data, 200);
        }

        return view('admin.dashboard.index', compact('countRequest', 'countContract', 'countUniqueRequest'));
    }
}

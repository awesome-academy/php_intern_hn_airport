<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Request as ModelsRequest;
use App\Repositories\Contract\ContractRepositoryInterface;
use App\Repositories\Request\RequestRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $requestRepo;
    protected $contractRepo;

    public function __construct(
        RequestRepositoryInterface $requestRepo,
        ContractRepositoryInterface $contractRepo
    ) {
        $this->requestRepo = $requestRepo;
        $this->contractRepo = $contractRepo;
    }

    public function index(Request $request) 
    {
        $today = Carbon::now();
        $today = $today->toDateString();
        $countRequest = $this->requestRepo->countRequestByDate($today);
        $countContract = $this->contractRepo->countContractByDate($today);
        $countUniqueRequest = $this->requestRepo->countUniqueRequestByDate($today);

        if ($request->ajax()) {
            $dataTitle = [
                trans('contents.admin.new_requests'),
                trans('contents.admin.cancel_requests'),
            ];
            $data = array();

            if ($request->type == config('constance.chart.monthly')) {
                $dataRequestInMonth = array();
                $dataCancelRequestInMonth = array();
                $dataDays = array();

                $month = date('m');
                $year = date('Y');
                $numberDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                $requestsInMonth = $this->requestRepo->getRequestByMonth($month);
                $cancelRequestsInMonth = $this->requestRepo->getCancelRequestByMonth($month);

                for ($i = 1; $i <= $numberDays; $i++) {
                    $countRequest = 0;
                    foreach ($requestsInMonth as $requestInMonth => $value) {
                        if ($i == $requestInMonth) {
                            $countRequest = count($value);

                            break;
                        }
                    }

                    $countCancelRequest = 0;
                    foreach ($cancelRequestsInMonth as $cancelRequestInMonth => $value) {
                        if ($i == $cancelRequestInMonth) {
                            $countCancelRequest = count($value);

                            break;
                        }
                    }

                    array_push($dataCancelRequestInMonth, $countCancelRequest);
                    array_push($dataRequestInMonth, $countRequest);
                    array_push($dataDays, $i);
                }

                $data = [
                    $dataTitle,
                    $dataDays,
                    $dataRequestInMonth,
                    $dataCancelRequestInMonth,
                ];
            } elseif ($request->type == config('constance.chart.yearly')) {
                $dataRequestInMonth = array();
                $dataCancelRequestInMonth = array();
                $dataMonths = [
                    trans('contents.common.month.jan'),
                    trans('contents.common.month.feb'),
                    trans('contents.common.month.mar'),
                    trans('contents.common.month.apr'),
                    trans('contents.common.month.may'),
                    trans('contents.common.month.june'),
                    trans('contents.common.month.july'),
                    trans('contents.common.month.aug'),
                    trans('contents.common.month.sep'),
                    trans('contents.common.month.oct'),
                    trans('contents.common.month.nov'),
                    trans('contents.common.month.dec'),
                ];

                for ($i = 1; $i <= config('constance.const.month_in_year'); $i++) { 
                    $countRequest = $this->requestRepo->countRequestByMonth($i);
                    $countCancelRequest = $this->requestRepo->countCancelRequestByMonth($i);

                    array_push($dataRequestInMonth, $countRequest);
                    array_push($dataCancelRequestInMonth, $countCancelRequest);

                }

                $data = [
                    $dataTitle,
                    $dataMonths,
                    $dataRequestInMonth,
                    $dataCancelRequestInMonth,
                ];
            }
            
            return response()->json($data, 200);
        }

        return view('admin.dashboard.index', compact('countRequest', 'countContract', 'countUniqueRequest'));
    }
}

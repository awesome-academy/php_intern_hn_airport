<?php

namespace App\Console\Commands;

use App\Exports\AdminDailyExport;
use App\Mail\AdminFilterRequestMail;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminFilterRequest extends Command
{
    protected $requestRepo;
    protected $userRepo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin_filter:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Filter outdated request and delete them, then send email to admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        RequestRepositoryInterface $requestRepo,
        UserRepositoryInterface $userRepo
    ) {
        parent::__construct();
        $this->requestRepo = $requestRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $requests = $this->requestRepo->getOutdateRequestByDate(Carbon::now());
            $users = $this->userRepo->getAllAdmin();

            $excelData = array();
            $index = 1;

            $email = [
                'title' => trans('contents.admin.email.title'),
                'body' => trans('contents.admin.email.filter_request'),
                'sender' => trans('contents.admin.email.sender'),
            ];

            if (count($requests) > 0) {
                foreach($requests as $request) {
                    $data = [];
                    array_push($data, $index);
                    foreach ($request->requestDestinations as $requestDestination) {
                        if ($requestDestination->type == config('constance.const.request_pickup')) {
                            array_push($data, $requestDestination->location);
                            break;
                        }
                    }
    
                    foreach ($request->requestDestinations as $requestDestination) {
                        if ($requestDestination->type == config('constance.const.request_dropoff')) {
                            array_push($data, $requestDestination->location);
                            break;
                        }
                    }
                            
                    array_push($data, $request->pickup);
                    array_push($data, $request->carTypes->type . ' ' . trans('contents.common.form.seat'));
                    array_push($data, $request->budget . ' ' . trans('contents.common.vnd'));
    
                    $index++;
                    array_push($excelData, $data);
                }
    
                $file = Excel::download(new AdminDailyExport($excelData), config('constance.excel.default'));

                $email['file'] = $file;
            }

            foreach ($users as $user) {
                Mail::to($user)->send(new AdminFilterRequestMail($email));
            }
            
            foreach ($requests as $request) {
                $request->update(['status' => config('constance.const.contract_cancel')]);
                $request->delete();
            }

            if ($email['file']) {
                Storage::delete(config('constance.excel.path') . $this->email['file']->getFile()->getFilename());
            }
        } catch (Exception $e) {

        }
    }
}

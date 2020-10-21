<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Http\Requests\StoreConfigDistancePost;
use App\Repositories\ConfigBasic\ConfigBasicRepositoryInterface;
use App\Repositories\ConfigDistance\ConfigDistanceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends ViewShareController
{
    protected $configBasicRepo;
    protected $configDistanceRepo;
    protected $viewShare;

    public function __construct(
        ViewShareController $viewShare,
        ConfigBasicRepositoryInterface $configBasicRepo,
        ConfigDistanceRepositoryInterface $configDistanceRepo
    ) {
        $this->viewShare = $viewShare;
        $this->configBasicRepo = $configBasicRepo;
        $this->configDistanceRepo = $configDistanceRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configBasics = $this->configBasicRepo->getAll();
        $configDistances = $this->configDistanceRepo->getAll();


        return view('admin.config.index', compact('configBasics', 'configDistances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigDistancePost $request)
    {
        try {
            DB::beginTransaction();

            $lastMaxConfig = $this->configDistanceRepo->findLastMaxConfig();

            if ($request->min != $lastMaxConfig->max) {
                alert()->error(trans('contents.common.alert.title.create_config_fail'), trans('contents.common.alert.message.create_config_fail'));
                return redirect()->back();
            }

            $inputDistance['min'] = $request->min;
            $inputDistance['max'] = $request->max;

            $createConfig = $this->configDistanceRepo->create($inputDistance);
            if ($createConfig) {
                $carTypes = $this->configBasicRepo->findAllCarTypes();

                $inputConfigBasic['distance_id'] = $createConfig->id;
                $inputConfigBasic['cost'] = $lastMaxConfig->cost;

                foreach ($carTypes as $carType) {
                    $inputConfigBasic['car_type_id'] = $carType->car_type_id;
                    $lowestCost = $this->configBasicRepo->findLowestCostCarType($carType->car_type_id);
                    $inputConfigBasic['cost'] = $lowestCost->cost;

                    $this->configBasicRepo->create($inputConfigBasic);
                }
            }

            DB::commit();
            alert()->success(trans('contents.common.alert.title.create_config_success'), trans('contents.common.alert.message.create_config_success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error(trans('contents.common.alert.title.unknow_error'), trans('contents.common.alert.message.unknow_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigDistancePost $request, $id)
    {
        try {
            DB::beginTransaction();

            if ($request->ajax()) {
                if ($request->type == config('constance.config_type.distance')) {
                    $configDistance = $this->configDistanceRepo->find($id);
                    $min = $request->min;
                    $max = $request->max;
                    
                    if ($min != $configDistance->min) {
                        $relativeDistance = $this->configDistanceRepo->findRelatedDistanceByMin($configDistance->min);
                        if ($relativeDistance) {
                            $this->configDistanceRepo->updateRelatedDistanceByMin($relativeDistance->id, $min);
                        }
                    }

                    if ($max != $configDistance->max) {
                        $relativeDistance = $this->configDistanceRepo->findRelatedDistanceByMax($configDistance->max);
                        if ($relativeDistance) {
                            $this->configDistanceRepo->updateRelatedDistanceByMax($relativeDistance->id, $max);
                        }
                    }
                    $input = [];
                    $input['min'] = $request->min;
                    $input['max'] = $request->max;

                    $this->configDistanceRepo->update($id, $input);

                    DB::commit();
                    $data = [
                        'title' => trans('contents.common.alert.title.update_config_success'),
                        'message' => trans('contents.common.alert.message.update_config_success'),
                    ];

                    return response()->json($data, 200);
                } elseif ($request->type == config('constance.config_type.cost')) {
                    $input['cost'] = $request->cost;
                    $this->configBasicRepo->update($id, $input);
                    
                    DB::commit();
                    $data = [
                        'title' => trans('contents.common.alert.title.update_config_success'),
                        'message' => trans('contents.common.alert.message.update_config_success'),
                    ];

                    return response()->json($data, 200);
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            $data = [
                'title' => trans('contents.common.alert.title.unknow_error'),
                'message' => trans('contents.common.alert.message.unknow_error'),
            ];

            return response()->json($data, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $deleteBasicConfig = $this->configBasicRepo->deleteConfigByDistance($id);
            if ($deleteBasicConfig) {
                $this->configDistanceRepo->delete($id);
            }
            
            DB::commit();
            $data = [
                'title' => trans('contents.common.alert.title.delete_config_success'),
                'message' => trans('contents.common.alert.message.delete_config_success'),
            ];

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = [
                'title' => trans('contents.common.alert.title.unknow_error'),
                'message' => trans('contents.common.alert.message.unknow_error'),
            ];

            return response()->json($data, 500);
        }
    }
}

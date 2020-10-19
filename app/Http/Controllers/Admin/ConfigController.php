<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewShare\ViewShareController;
use App\Repositories\ConfigBasic\ConfigBasicRepositoryInterface;
use App\Repositories\ConfigDistance\ConfigDistanceRepositoryInterface;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

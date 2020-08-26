@extends('host.layout')

@section('title', 'Host Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.host.detail') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.host.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.host.detail') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('contents.host.request_detail') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">{{ trans('contents.host.request_name') }}</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label for="inputName">{{ trans('contents.host.request_phone') }}</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label for="inputName">{{ trans('contents.host.request_pickup_location') }}</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label for="inputName">{{ trans('contents.host.request_dropoff_location') }}</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label for="inputName">{{ trans('contents.host.request_pickup_time') }}</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label for="inputName">{{ trans('contents.host.request_note') }}</label>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('contents.host.driver') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ trans('contents.host.driver_name') }}</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('contents.host.driver_phone') }}</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('contents.host.driver_image') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

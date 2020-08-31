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
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('contents.host.detail') }}</h3>
                    </div>
                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ trans('contents.host.form.province') }}</label>
                                        <select class="form-control">
                                            <option value="">{{ trans('contents.host.form.province_default') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ trans('contents.host.form.car_type') }}</label>
                                        <select class="form-control">
                                            <option value="">{{ trans('contents.host.form.car_type_default') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label>{{ trans('contents.host.form.quantity') }}</label>
                                    <input type="text" class="form-control" placeholder=".col-4">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">{{ trans('contents.host.form.submit') }}</button>
                            <button class="btn btn-primary">{{ trans('contents.host.form.add_detail') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

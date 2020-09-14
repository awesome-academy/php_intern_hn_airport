@extends('agency.layout')

@section('title', 'Agency Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.common.contract_detail') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.common.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.common.contract_detail') }}</li>
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
                        <h3 class="card-title">{{ trans('contents.common.request_detail') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" 
                                data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.table.user_name') }}</h5>
                            <p class="col-md-8 lead">
                                @if ($contractDetail->request->requestCustomer)
                                    {{ $contractDetail->request->requestCustomer->name }}
                                @else
                                    {{ $contractDetail->request->user->name }}
                                @endif
                            </p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.table.user_phone') }}</h5>
                            <p class="col-md-8 lead">
                                @if ($contractDetail->request->requestCustomer)
                                    {{ $contractDetail->request->requestCustomer->phone }}
                                @else
                                    {{ $contractDetail->request->user->phone }}
                                @endif
                            </p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.price') }}</h5>
                            <p class="col-md-8 lead">
                                {{ $contractDetail->request->budget }} {{ trans('contents.common.vnd') }}
                            </p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.datetime') }}</h5>
                            <p class="col-md-8 lead">{{ $contractDetail->request->pickup }}</p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.pickup') }}</h5>
                            <ul class="col-md-8">
                                @foreach ($contractDetail->request->requestDestinations as $requestDestination)
                                    @if ($requestDestination->type == config('constance.const.request_pickup'))
                                        <li class="lead">{{ $requestDestination->location }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.drop_off') }}</h5>
                            <ul class="col-md-8">
                                @foreach ($contractDetail->request->requestDestinations as $requestDestination)
                                    @if ($requestDestination->type == config('constance.const.request_dropoff'))
                                        <li class="lead">{{ $requestDestination->location }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.note') }}</h5>
                            <p class="col-md-8 lead">{{ $contractDetail->request->note }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('contents.common.driver') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" 
                                data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.driver_name') }}</label>
                                @error('name')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('name') is-invalid @enderror" disabled
                                    name="name" value="{{ $contractDetail->contractDriver->name }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.driver_phone') }}</label>
                                @error('phone')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" disabled
                                    name="phone" value="{{ $contractDetail->contractDriver->phone }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.car_plate') }}</label>
                                @error('car_plate')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('car_plate') is-invalid @enderror" disabled
                                    name="car_plate" value="{{ $contractDetail->contractDriver->car_plate }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.car_name') }}</label>
                                @error('car_name')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('car_name') is-invalid @enderror" disabled
                                    name="car_name" value="{{ $contractDetail->contractDriver->car_name }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.driver_image') }}</label>
                                @error('avatar')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <img class="img-fluid" src="{{ asset('storage/' . $contractDetail->contractDriver->avatar) }}" 
                                    id="driver-avatar">
                                <input type="file" name="avatar" hidden>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

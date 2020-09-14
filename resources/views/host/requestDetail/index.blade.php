@extends('host.layout')

@section('title', 'Host Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.common.request_detail') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.common.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.common.request_detail') }}</li>
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
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.table.user_name') }}</h5>
                            <p class="col-md-8 lead">
                                @if ($requestDetail->requestCustomer)
                                    {{ $requestDetail->requestCustomer->name }}
                                @else
                                    {{ $requestDetail->user->name }}
                                @endif
                            </p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.table.user_phone') }}</h5>
                            <p class="col-md-8 lead">
                                @if ($requestDetail->requestCustomer)
                                    {{ $requestDetail->requestCustomer->phone }}
                                @else
                                    {{ $requestDetail->user->phone }}
                                @endif
                            </p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.price') }}</h5>
                            <p class="col-md-8 lead">
                                {{ $requestDetail->budget }} {{ trans('contents.common.vnd') }}
                            </p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.datetime') }}</h5>
                            <p class="col-md-8 lead">{{ $requestDetail->pickup }}</p>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.pickup') }}</h5>
                            <ul class="col-md-8">
                                @foreach ($requestDetail->requestDestinations as $requestDestination)
                                    @if ($requestDestination->type == config('constance.const.request_pickup'))
                                        <li class="lead">{{ $requestDestination->location }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.drop_off') }}</h5>
                            <ul class="col-md-8">
                                @foreach ($requestDetail->requestDestinations as $requestDestination)
                                    @if ($requestDestination->type == config('constance.const.request_dropoff'))
                                        <li class="lead">{{ $requestDestination->location }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-md-4">{{ trans('contents.common.form.note') }}</h5>
                            <p class="col-md-8 lead">{{ $requestDetail->note }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('contents.common.driver') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <form action="{{ route('host.requests.update', $requestDetail->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.driver_name') }}</label>
                                @error('name')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.driver_phone') }}</label>
                                @error('phone')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.car_plate') }}</label>
                                @error('car_plate')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('car_plate') is-invalid @enderror" 
                                    name="car_plate" value="{{ old('car_plate') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.car_name') }}</label>
                                @error('car_name')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="text" class="form-control @error('car_name') is-invalid @enderror" 
                                    name="car_name" value="{{ old('car_name') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('contents.common.form.driver_image') }}</label>
                                @error('avatar')
                                    <label class="text-danger"><i class="far fa-times-circle"></i>{{ $message }}</label>
                                @enderror
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">{{ trans('contents.common.form.add_driver') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@extends('agency.layout')

@section('title', 'Agency Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.common.request_detail') }}</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('contents.common.request_detail') }}</h3>
                </div>
                <div class="card-body">
                    <form role="form">
                        <div class="form-group">
                            <input type="text" id="request-id" class="form-control"
                                value="{{ $requestDetail->id }}" hidden>
                        </div>
                        <div class="form-group">
                            <input type="text" id="request-budget" class="form-control"
                                value="{{ $requestDetail->budget }} {{ trans('contents.common.vnd') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('contents.common.form.car_type') }}</label>
                            <label id="airport-car-type-error" class="text-danger"></label>
                            <select class="form-control" id="airport-car-type"
                                @if ($requestDetail->status != config('constance.const.request_new')) disabled @endif>
                                <option value="">{{ trans('contents.common.form.choose_car') }}
                                </option>
                                @foreach ($carTypes as $carType)
                                    <option value="{{ $carType->id }}" @if ($carType->id == $requestDetail->car_type_id)
                                        selected
                                        @endif>{{ $carType->type }} {{ trans('contents.common.form.seat')}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('contents.common.form.province') }}</label>
                            <label id="airport-province-error" class="text-danger"></label>
                            <select class="form-control" id="airport-province"
                                @if ($requestDetail->status != config('constance.const.request_new')) disabled @endif>
                                <option value="">{{ trans('contents.common.form.choose_province') }}
                                </option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" @if ($requestDetail->provinceAirports->provinces->id
                                        == $province->id)
                                        selected
                                        @endif>{{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('contents.common.form.airport') }}</label>
                            <input type="text" id="airport-province-airport" class="form-control"
                                value="{{ $requestDetail->provinceAirports->name }}" disabled>
                            <input type="text" id="airport-province-airport-id" class="form-control"
                                value="{{ $requestDetail->province_airport_id }}" hidden>
                        </div>

                        @foreach ($requestDetail->requestDestinations as $requestDestination)
                            @if ($requestDestination->location == $requestDetail->provinceAirports->name)
                                @if ($requestDestination->type == config('constance.const.request_dropoff'))
                                    <div class="form-group airport-pickup">
                                        <label id="airport-pickup-error" class="text-danger"></label>
                                        <label>{{ trans('contents.common.form.pickup') }}</label>
                                        <button type="button" class="btn btn-sm btn-default float-right"
                                            id="btn-airport-add-pickup">{{ trans('contents.common.form.add_pickup') }}</i></button>
                                        <div class="input-group">
                                            @foreach ($requestDetail->requestDestinations as $requestDestination)
                                                @if ($requestDestination->type == config('constance.const.request_pickup') &&
                                                $requestDestination->location != $requestDetail->provinceAirports->name)
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" value="{{ $requestDestination->location }}">
                                                        <div class="input-group-append">
                                                            <button
                                                                class="input-group-text btn-clear">{{ trans('contents.common.x') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach

                        <div class="form-group">
                            <label>{{ trans('contents.common.form.datetime') }}</label>
                            <label id="airport-datetime-error" class="text-danger"></label>
                            <input type="text" class="form-control datetimepicker-input" id="airport-datetime"
                                data-toggle="datetimepicker" data-target="#airport-datetime"
                                value="{{ $requestDetail->pickup }}" 
                                @if ($requestDetail->status != config('constance.const.request_new')) disabled @endif/>
                        </div>
                        <div class="form-group airport-drop-off">
                            <label>{{ trans('contents.common.form.drop_off') }}</label>
                            @if ($requestDetail->status == config('constance.const.request_new'))
                                <button type="button" class="btn btn-sm btn-default float-right"
                                    id="btn-airport-add-drop-off">{{ trans('contents.common.form.add_dropoff') }}</i></button>
                            @endif
                            <div class="input-group">
                                @foreach ($requestDetail->requestDestinations as $requestDestination)
                                    @if ($requestDestination->type == config('constance.const.request_dropoff') &&
                                    $requestDestination->location != $requestDetail->provinceAirports->name)
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="{{ $requestDestination->location }}"
                                                @if ($requestDetail->status != config('constance.const.request_new')) disabled @endif>
                                            <div class="input-group-append">
                                                <button
                                                    class="input-group-text btn-clear">{{ trans('contents.common.x') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('contents.common.form.note') }}</label>
                            <textarea class="form-control" rows="3" id="airport-note"
                                @if ($requestDetail->status != config('constance.const.request_new')) disabled @endif
                                >{{ $requestDetail->note }}</textarea>
                        </div>
                        <div class="form-group">
                            @foreach ($requestDetail->requestDestinations as $requestDestination)
                                @if ($requestDestination->location == $requestDetail->provinceAirports->name)
                                    @if ($requestDestination->type == config('constance.const.request_dropoff'))
                                        <input type="text" value=" {{ config('constance.const.request_dropoff') }}"
                                            id="request-type" hidden>
                                    @else
                                        <input type="text" value=" {{ config('constance.const.request_pickup') }}" id="request-type"
                                            hidden>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        @if ($requestDetail->status == config('constance.const.request_new'))
                            <div class="form-group">
                                <button type="button" class="btn btn-primary"
                                    id="btn-update-request">{{ trans('contents.common.form.update') }}</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

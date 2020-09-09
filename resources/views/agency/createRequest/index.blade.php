@extends('agency.layout')

@section('title', 'Agency Local Driver')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.agency.create_request') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a
                        href="{{ route('agency.requests.create') }}">{{ trans('contents.common.home') }}</a></li>
                    <li class="breadcrumb-item"><a
                        href="{{ route('agency.requests.index') }}">{{ trans('contents.common.request') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.agency.create_request') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="accordion-to-airport">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion-to-airport"
                                            href="#collapse-to-airport">
                                            {{ trans('contents.common.form.to_airport') }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-to-airport" class="panel-collapse collapse in">
                                    <form role="form">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.car_type') }}</label>
                                                <label id="to-airport-car-type-error" class="text-danger"></label>
                                                <select class="form-control" id="to-airport-car-type">
                                                    <option value="">{{ trans('contents.common.form.choose_car') }}
                                                    </option>
                                                    @foreach ($carTypes as $carType)
                                                        <option value="{{ $carType->id }}">{{ $carType->type }}
                                                            {{ trans('contents.common.form.seat')}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.province') }}</label>
                                                <label id="to-airport-province-error" class="text-danger"></label>
                                                <select class="form-control" id="to-airport-province">
                                                    <option value="">{{ trans('contents.common.form.choose_province') }}
                                                    </option>
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->id }}">{{ $province->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.airport') }}</label>
                                                <input type="text" class="form-control" disabled
                                                    id="to-airport-airport">
                                            </div>
                                            <div class="form-group to-airport-pickup">
                                                <label>{{ trans('contents.common.form.pickup') }}</label>
                                                <label id="to-airport-pickup-error" class="text-danger"></label>
                                                <button type="button" class="btn btn-sm btn-default float-right"
                                                    id="btn-to-airport-add-pickup">{{ trans('contents.common.form.add_pickup') }}</i></button>
                                                <div class="input-group">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.datetime') }}</label>
                                                <label id="to-airport-datetime-error" class="text-danger"></label>
                                                <input type="text" class="form-control datetimepicker-input"
                                                    id="to-airport-datetime" data-toggle="datetimepicker"
                                                    data-target="#to-airport-datetime" />
                                            </div>
                                            <div class="form-check">
                                                <label>{{ trans('contents.common.form.ways') }}</label>
                                                <div class="col-md-6">
                                                    <input class="form-check-input" type="radio" name="ways" checked=""
                                                        value="0">
                                                    <label
                                                        class="form-check-label">{{ trans('contents.common.form.1_way') }}</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input class="form-check-input" type="radio" name="ways" value="1">
                                                    <label
                                                        class="form-check-label">{{ trans('contents.common.form.2_way') }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group to-airport-drop-off">
                                                <label>{{ trans('contents.common.form.drop_off') }}</label>
                                                <button type="button" class="btn btn-sm btn-default float-right"
                                                    id="btn-to-airport-add-drop-off">{{ trans('contents.common.form.add_dropoff') }}</i></button>
                                                <div class="input-group">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.note') }}</label>
                                                <textarea class="form-control" rows="3" id="to-airport-note"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary"
                                                id="btn-to-airport-submit">{{ trans('contents.common.form.submit') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="accordion-from-airport">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion-from-airport"
                                            href="#collapse-frop-airport">
                                            {{ trans('contents.common.form.from_airport') }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-frop-airport" class="panel-collapse collapse in">
                                    <form role="form">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.car_type') }}</label>
                                                <label id="from-airport-car-type-error" class="text-danger"></label>
                                                <select class="form-control" id="from-airport-car-type">
                                                    <option value="">{{ trans('contents.common.form.choose_car') }}
                                                    </option>
                                                    @foreach ($carTypes as $carType)
                                                        <option value="{{ $carType->id }}">{{ $carType->type }}
                                                            {{ trans('contents.common.form.seat')}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.province') }}</label>
                                                <label id="from-airport-province-error" class="text-danger"></label>
                                                <select class="form-control" id="from-airport-province">
                                                    <option value="">{{ trans('contents.common.form.choose_province') }}
                                                    </option>
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->id }}">{{ $province->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.airport') }}</label>
                                                <input type="text" class="form-control" disabled id="from-airport-airport">
                                            </div>
                                            <div class="form-group from-airport-drop-off">
                                                <label>{{ trans('contents.common.form.drop_off') }}</label>
                                                <label id="from-airport-drop-off-error" class="text-danger"></label>
                                                <button type="button" class="btn btn-sm btn-default float-right"
                                                    id="btn-from-airport-add-drop-off">{{ trans('contents.common.form.add_dropoff') }}</i></button>
                                                <div class="input-group">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.datetime') }}</label>
                                                <label id="from-airport-datetime-error" class="text-danger"></label>
                                                <input type="text" class="form-control datetimepicker-input"
                                                    id="from-airport-datetime" data-toggle="datetimepicker"
                                                    data-target="#from-airport-datetime" />
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.flight_no') }}</label>
                                                <input type="text" class="form-control" id="from-airport-flight">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.common.form.note') }}</label>
                                                <textarea class="form-control" rows="3" id="from-airport-note"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" id="btn-from-airport-submit"
                                                class="btn btn-primary">{{ trans('contents.common.form.submit') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

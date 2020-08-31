@extends('agency.layout')

@section('title', 'Agency Local Driver')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.agency.dashboard') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.agency.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.agency.dashboard') }}</li>
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
                                            {{ trans('contents.agency.request_to_airport') }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-to-airport" class="panel-collapse collapse in">
                                    <form role="form">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.province') }}</label>
                                                <select class="form-control">
                                                    <option value="">{{ trans('contents.agency.form.choose_province') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.airport') }}</label>
                                                <select class="form-control">
                                                    <option value="">{{ trans('contents.agency.form.choose_airport') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.pickup') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-check"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.date') }}</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#reservationdate">
                                                    <div class="input-group-append" data-target="#reservationdate"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <label>{{ trans('contents.agency.form.ways') }}</label>
                                                <div class="col-md-6">
                                                    <input class="form-check-input" type="radio" name="radio1"
                                                        checked="">
                                                    <label
                                                        class="form-check-label">{{ trans('contents.agency.form.1_way') }}</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input class="form-check-input" type="radio" name="radio2">
                                                    <label
                                                        class="form-check-label">{{ trans('contents.agency.form.2_way') }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.note') }}</label>
                                                <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit"
                                                class="btn btn-primary">{{ trans('contents.common.submit') }}</button>
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
                                            {{ trans('contents.agency.request_from_airport') }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-frop-airport" class="panel-collapse collapse in">
                                    <form role="form">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.province') }}</label>
                                                <select class="form-control">
                                                    <option value="">{{ trans('contents.agency.form.choose_province') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.airport') }}</label>
                                                <select class="form-control">
                                                    <option value="">{{ trans('contents.agency.form.choose_airport') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.dropoff') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-check"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.date') }}</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#reservationdate">
                                                    <div class="input-group-append" data-target="#reservationdate"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.flight_no') }}</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('contents.agency.form.note') }}</label>
                                                <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit"
                                                class="btn btn-primary">{{ trans('contents.common.submit') }}</button>
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

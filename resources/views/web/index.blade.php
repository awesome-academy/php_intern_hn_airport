@extends('web.layout')

@section('title', 'Local Driver')

<section class="banner-area relative" id="home">
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row fullscreen d-flex align-items-center justify-content-center">
            <div class="banner-content col-lg-7 col-md-6 ">
                <h6 class="text-white ">{{ trans('contents.web.title') }}</h6>
                <h1 class="text-white text-uppercase">
                    {{ trans('contents.web.headline') }}
                </h1>
                <p class="pt-20 pb-20 text-white">
                    {{ trans('contents.web.body') }}
                </p>
                <a href="#" class="primary-btn text-uppercase">{{ trans('contents.web.join') }}</a>
            </div>
            <div class="col-lg-5  col-md-6 header-right">
                <h4 class="text-white pb-30">{{ trans('contents.web.form.title') }}</h4>
                <form class="form" role="form" autocomplete="off">
                    <div class="form-group">
                        <div class="default-select" id="default-select">
                            <select id="request-type">
                                <option value="0" selected>{{ trans('contents.web.form.to_airport') }}</option>
                                <option value="1">{{ trans('contents.web.form.from_airport') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="default-select">
                            <select id="request-car-type">
                                <option value="0" selected>{{ trans('contents.common.form.car_type') }}</option>
                                @foreach ($carTypes as $carType)
                                    <option value="{{ $carType->id }}">{{ $carType->type }} {{ trans('contents.common.form.seat') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="from-group">
                        <input class="form-control txt-field" type="text" name="" placeholder="{{ trans('contents.common.form.pickup') }}" id="to-airport-pickup">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 wrap-left">
                            <div class="default-select">
                                <select id="request-province">
                                    <option value="" selected>{{ trans('contents.common.form.province') }}</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 wrap-right">
                            <div class="input-group dates-wrap">
                                <input id="datepicker" class="dates form-control" id="exampleAmount"
                                    placeholder="{{ trans('contents.common.form.datetime') }}" type="text">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="lnr lnr-calendar-full"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="from-group">
                        <input class="form-control txt-field" type="text" name="" placeholder="{{ trans('contents.common.form.drop_off') }}" disabled id="to-airport-dropoff">
                    </div>
                    <div class="from-group">
                        <input class="form-control txt-field" type="text" name="" placeholder="{{ trans('contents.common.form.pickup') }}" disabled id="from-airport-pickup">
                    </div>
                    <div class="from-group">
                        <input class="form-control txt-field" type="text" name="" placeholder="{{ trans('contents.common.form.drop_off') }}" id="from-airport-dropoff">
                    </div>
                    <div class="from-group">
                        <input class="form-control txt-field" type="text" name="name" placeholder="{{ trans('contents.common.form.name') }}">
                        <input class="form-control txt-field" type="tel" name="phone" placeholder="{{ trans('contents.common.form.phone') }}">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="reset"
                                class="btn btn-default btn-lg btn-block text-center text-uppercase">{{ trans('contents.web.form.confirm') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

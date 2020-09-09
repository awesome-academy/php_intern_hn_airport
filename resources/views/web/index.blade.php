@extends('web.layout')

@section('title', 'Local Driver')

@section('content')
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
                    <a href="{{ route('agency.signup.index') }}" class="primary-btn text-uppercase">{{ trans('contents.web.join') }}</a>
                </div>
                <div class="col-lg-5  col-md-6 header-right">
                    <h4 class="text-white pb-30">{{ trans('contents.web.form.title') }}</h4>
                    <form class="form" role="form" autocomplete="off" method="POST" action="{{ route('store') }}">
                        <div class="form-group">
                            <div class="default-select" id="default-select">
                                <select id="request-type">
                                    <option value="{{ config('constance.const.zero') }}" selected>{{ trans('contents.common.form.to_airport') }}</option>
                                    <option value="{{ config('constance.const.one') }}">{{ trans('contents.common.form.from_airport') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="error" id="error-car-type"></div>
                            <div class="default-select">
                                <select id="request-car-type" name="car_type">
                                    <option value="" selected>{{ trans('contents.common.form.car_type') }}</option>
                                    @foreach ($carTypes as $carType)
                                        <option value="{{ $carType->id }}">{{ $carType->type }}
                                            {{ trans('contents.common.form.seat') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="from-group">
                            <div class="error" id="error-to-airport-pickup"></div>
                            <input class="form-control txt-field" type="text" name="pickup_to_airport"
                                placeholder="{{ trans('contents.common.form.pickup') }}" id="to-airport-pickup">
                        </div>
                        <div class="form-group">
                            <div class="error" id="error-province"></div>
                            <div class="default-select" id="default-select-province">
                                <select id="request-province" name="province">
                                    <option value="" selected>{{ trans('contents.common.form.province') }}</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="error" id="error-datetime"></div>
                            <div class="input-group">
                                <input type='text' class="dates form-control" id='datetimepicker' 
                                    placeholder="{{ trans('contents.common.form.datetime') }}"/>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="lnr lnr-calendar-full"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="from-group">
                            <div class="error" id="error-to-airport-dropoff"></div>
                            <input class="form-control txt-field" type="text" name="dropoff_to_airport"
                                placeholder="{{ trans('contents.common.form.drop_off') }}" disabled id="to-airport-dropoff">
                        </div>
                        <div class="from-group">
                            <div class="error" id="error-from-airport-pickup"></div>
                            <input class="form-control txt-field" type="text" name="pickup_from_airport"
                                placeholder="{{ trans('contents.common.form.pickup') }}" disabled id="from-airport-pickup">
                        </div>
                        <div class="from-group">
                            <div class="error" id="error-from-airport-dropoff"></div>
                            <input class="form-control txt-field" type="text" name="dropoff_from_airport"
                                placeholder="{{ trans('contents.common.form.drop_off') }}" id="from-airport-dropoff">
                        </div>
                        <div class="from-group">
                            <div class="error" id="error-name"></div>
                            <input class="form-control txt-field" type="text" name="name"
                                placeholder="{{ trans('contents.common.form.name') }}">   
                        </div>
                        <div class="form-group">
                            <div class="error" id="error-phone"></div>
                            <input class="form-control txt-field" type="tel" name="phone"
                                placeholder="{{ trans('contents.common.form.phone') }}">
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button class="btn btn-default btn-lg btn-block text-center text-uppercase"
                                    id="btn-checkout">{{ trans('contents.web.form.confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


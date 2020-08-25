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
                        <div class="default-select" id="default-select"">
                            <select>
                                <option value="" disabled selected hidden>{{ trans('contents.web.form.car_type') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 wrap-left">
                            <div class="default-select" id="default-select"">
                                <select>
                                    <option value="" disabled selected hidden>{{ trans('contents.web.form.pickup') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 wrap-right">
                            <div class="input-group dates-wrap">
                                <input id="datepicker" class="dates form-control" id="exampleAmount"
                                    placeholder="Date & time" type="text">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="lnr lnr-calendar-full"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 wrap-left">
                            <div class="default-select" id="default-select"">
                                <select>
                                    <option value="" disabled selected hidden>{{ trans('contents.web.form.drop_off') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 wrap-right">
                            <div class="input-group dates-wrap">
                                <input id="datepicker2" class="dates form-control" id="exampleAmount"
                                    placeholder="Date & time" type="text">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="lnr lnr-calendar-full"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="from-group">
                        <input class="form-control txt-field" type="text" name="name" placeholder="{{ trans('contents.web.form.name') }}">
                        <input class="form-control txt-field" type="tel" name="phone" placeholder="{{ trans('contents.web.form.phone') }}">
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

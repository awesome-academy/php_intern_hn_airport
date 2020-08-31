@extends('host.layout')

@section('title', 'Host Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.host.requests') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.host.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.host.requests') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                            href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                            aria-selected="true">{{ trans('contents.host.new') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                            href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                            aria-selected="false">{{ trans('contents.host.canceled') }}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                        aria-labelledby="custom-tabs-four-home-tab">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title col-md-8">{{ trans('contents.host.list_requests') }}</h3>
                                    <button type="button" class="btn btn-block btn-default col-md-2"
                                        id="btn-add">{{ trans('contents.host.add_request') }}</button>
                                </div>
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('contents.host.table.id') }}</th>
                                                <th>{{ trans('contents.host.table.pickup_location') }}</th>
                                                <th>{{ trans('contents.host.table.droopoff_location') }}</th>
                                                <th>{{ trans('contents.host.table.pickup_time') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-four-profile-tab">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title col-md-8">{{ trans('contents.host.list_requests') }}</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('contents.host.table.id') }}</th>
                                                <th>{{ trans('contents.host.table.pickup_location') }}</th>
                                                <th>{{ trans('contents.host.table.droopoff_location') }}</th>
                                                <th>{{ trans('contents.host.table.pickup_time') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}">
</script>
<script
    src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
</script>
<script
    src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
</script>
<script
    src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
</script>

@endsection

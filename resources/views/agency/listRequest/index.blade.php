@extends('agency.layout')

@section('title', 'Agency Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.common.request') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.common.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.common.request') }}</li>
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
                            aria-selected="true">{{ trans('contents.common.table.new') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                            href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                            aria-selected="false">{{ trans('contents.common.table.cancel') }}</a>
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
                                    <h3 class="card-title col-md-8">{{ trans('contents.common.list_request') }}</h3>
                                    <a href="{{ route('agency.requests.create') }}" class="btn btn-block btn-default col-md-2"
                                        style="float: right">{{ trans('contents.agency.create_request') }}</a>
                                </div>
                                <div class="card-body">
                                    <table id="table-request-new" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('contents.common.table.id') }}</th>
                                                <th>{{ trans('contents.common.form.pickup') }}</th>
                                                <th>{{ trans('contents.common.form.drop_off') }}</th>
                                                <th>{{ trans('contents.common.form.datetime') }}</th>
                                                <th>{{ trans('contents.common.table.car_type') }}</th>
                                                <th>{{ trans('contents.common.form.price') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $indexNew = 1; @endphp

                                            @foreach ($requestNew as $request)
                                                <tr>
                                                    <td>{{ $indexNew }}</td>
                                                    @foreach ($request->requestDestinations as $requestDestination)
                                                        @if ($requestDestination->type == config('constance.const.request_pickup'))
                                                            <td>{{ $requestDestination->location }}</td>
                                                            @php break; @endphp
                                                        @endif
                                                    @endforeach
                                                    @foreach ($request->requestDestinations as $requestDestination)
                                                        @if ($requestDestination->type == config('constance.const.request_dropoff'))
                                                            <td>{{ $requestDestination->location }}</td>
                                                            @php break; @endphp
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $request->pickup }}</td>
                                                    <td>{{ $request->carTypes->type }} {{ trans('contents.common.form.seat') }}</td>
                                                    <td>{{ $request->budget }} {{ trans('contents.common.vnd') }}</td>
                                                    <td>
                                                        <a href="{{ route('agency.requests.show', $request->id) }}" class="btn btn-warning btn-detail">
                                                            <i class="fa fa-eye"></i>{{ trans('contents.common.table.view') }}</a>
                                                        <button type="button" class="btn btn-danger btn-delete-request" value="{{ $request->id }}">
                                                            <i class="fa fa-trash"></i>{{ trans('contents.common.table.delete') }}</button>
                                                    </td>
                                                </tr>
                                                @php $indexNew++; @endphp
                                            @endforeach
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
                                    <h3 class="card-title col-md-8">{{ trans('contents.common.list_request') }}</h3>
                                </div>
                                <div class="card-body">
                                    <table id="table-request-canceled" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('contents.common.table.id') }}</th>
                                                <th>{{ trans('contents.common.form.pickup') }}</th>
                                                <th>{{ trans('contents.common.form.drop_off') }}</th>
                                                <th>{{ trans('contents.common.form.datetime') }}</th>
                                                <th>{{ trans('contents.common.table.car_type') }}</th>
                                                <th>{{ trans('contents.common.form.price') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $indexCancel = 1; @endphp

                                            @foreach ($requestCancel as $request)
                                                <tr>
                                                    <td>{{ $indexCancel }}</td>
                                                    @foreach ($request->requestDestinations as $requestDestination)
                                                        @if ($requestDestination->type == config('constance.const.request_pickup'))
                                                            <td>{{ $requestDestination->location }}</td>
                                                            @php break; @endphp
                                                        @endif
                                                    @endforeach
                                                    @foreach ($request->requestDestinations as $requestDestination)
                                                        @if ($requestDestination->type == config('constance.const.request_dropoff'))
                                                            <td>{{ $requestDestination->location }}</td>
                                                            @php break; @endphp
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $request->pickup }}</td>
                                                    <td>{{ $request->carTypes->type }} {{ trans('contents.common.form.seat') }}</td>
                                                    <td>{{ $request->budget }} {{ trans('contents.common.vnd') }}</td>
                                                    <td>
                                                        <a href="{{ route('agency.requests.show', $request->id) }}" class="btn btn-warning btn-detail">
                                                            <i class="fa fa-eye"></i>{{ trans('contents.common.table.view') }}</a>
                                                    </td>
                                                </tr>
                                                @php $indexCancel++; @endphp
                                            @endforeach
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

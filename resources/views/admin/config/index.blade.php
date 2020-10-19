@extends('admin.layout')

@section('title', config('constance.title.title_admin'))

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.admin.config.basic') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('contents.common.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.admin.config.basic') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('contents.admin.config.add_distance') }}</h3>
                    </div>
                    <form role="form" action="{{ route('admin.configs.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{ trans('contents.common.form.min') }}</label>
                                        @error('min')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        <input type="text" class="form-control @error('min') is-invalid @enderror" 
                                            name="min" value="{{ old('min') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{ trans('contents.common.form.max') }}</label>
                                        @error('max')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        <input type="text" class="form-control @error('max') is-invalid @enderror" 
                                            name="max" value="{{ old('max') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary"
                                type="submit">{{ trans('contents.admin.config.add_distance') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                    href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                    aria-selected="true">{{ trans('contents.admin.config.distance') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                                    aria-selected="false">{{ trans('contents.admin.config.basic') }}</a>
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
                                            <h3 class="card-title col-md-8">{{ trans('contents.admin.config.distance') }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <table id="table-distance-basic" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('contents.common.table.number') }}</th>
                                                        <th>{{ trans('contents.common.form.min') }}</th>
                                                        <th>{{ trans('contents.common.form.max') }}</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $indexDistance = 1 @endphp
                                                    @foreach ($configDistances as $config)
                                                        <tr>
                                                            <td>{{ $indexDistance }}</td>
                                                            <td>{{ $config->min }} {{ trans('contents.common.km') }}</td>
                                                            <td>{{ $config->max }} {{ trans('contents.common.km') }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-warning btn-distance-detail">
                                                                    <i class="fa fa-eye"></i>{{ trans('contents.common.table.view') }}</button>
                                                            </td>
                                                        </tr>
                                                        @php $indexDistance++ @endphp
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
                                            <h3 class="card-title col-md-8">{{ trans('contents.admin.config.basic') }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <table id="table-config-basic" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('contents.common.table.number') }}</th>
                                                        <th>{{ trans('contents.common.table.car_type') }}</th>
                                                        <th>{{ trans('contents.common.form.min') }}</th>
                                                        <th>{{ trans('contents.common.form.max') }}</th>
                                                        <th>{{ trans('contents.common.form.cost') }}</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $indexBasic = 1 @endphp
                                                    @foreach ($configBasics as $config)
                                                        <tr>
                                                            <td>{{ $indexBasic }}</td>
                                                            <td>{{ $config->carTypes->type }}  {{ trans('contents.common.form.seat') }}</td>
                                                            <td>{{ $config->configDistances->min }} {{ trans('contents.common.km') }}</td>
                                                            <td>{{ $config->configDistances->max }} {{ trans('contents.common.km') }}</td>
                                                            <td>{{ $config->cost }} {{ trans('contents.common.vnd') }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-warning btn-config-detail">
                                                                    <i class="fa fa-eye"></i>{{ trans('contents.common.table.view') }}</button>
                                                            </td>
                                                        </tr>
                                                        @php $indexBasic++ @endphp
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
        </div>
    </div>

    <div class="modal fade" id="modal-config-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('contents.admin.config.basic') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">{{ trans('contents.common.x') }}</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4">{{ trans('contents.common.table.car_type') }}</label>
                                <div class="col-sm-8">
                                    <input class="form-control" disabled id="detail-car-type" name="car_type_id">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">{{ trans('contents.common.form.min') }}</label>
                                <div class="col-sm-8">
                                    <input class="form-control" disabled id="detail-min" name="min">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">{{ trans('contents.common.form.max') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" disabled id="detail-max" name="max">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">{{ trans('contents.common.form.cost') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="detail-cost" name="cost">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ trans('contents.common.form.close') }}</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-update">{{ trans('contents.common.form.update') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-distance-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('contents.admin.config.distance') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">{{ trans('contents.common.x') }}</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4">{{ trans('contents.common.form.min') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="distance-min" name="min">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">{{ trans('contents.common.form.max') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="distance-max" name="max">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ trans('contents.common.form.close') }}</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-update-distance">{{ trans('contents.common.form.update') }}</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script
    src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
</script>
<script
    src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
</script>
<script
    src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
</script>
<script src="{{ asset('js/admin/config/basic.js') }}"></script>

@endsection

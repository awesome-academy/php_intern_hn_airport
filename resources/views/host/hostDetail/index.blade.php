@extends('host.layout')

@section('title', 'Host Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.host.add_detail') }}</h1>
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
                        <h3 class="card-title">{{ trans('contents.host.detail') }}</h3>
                    </div>
                    <form role="form" action="{{ route('host.postDetail') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ trans('contents.common.form.province') }}</label>
                                        @error('province_id')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        <select class="form-control @error('province_id') is-invalid @enderror"
                                            name="province_id">
                                            @if (!old('province_id'))
                                                <option value="">{{ trans('contents.common.form.choose_province') }}
                                                </option>
                                            @endif
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}"
                                                    {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                    {{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>{{ trans('contents.common.form.car_type') }}</label>
                                        @error('car_type_id')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        <select class="form-control @error('car_type_id') is-invalid @enderror"
                                            name="car_type_id">
                                            @if (!old('car_type_id'))
                                                <option value="">{{ trans('contents.common.form.car_type') }}</option>
                                            @endif
                                            @foreach ($carTypes as $carType)
                                                <option value="{{ $carType->id }}"
                                                    {{ old('car_type_id') == $carType->id ? 'selected' : '' }}>
                                                    {{ $carType->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label>{{ trans('contents.common.form.quantity') }}</label>
                                    @error('quantity')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                    <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                                        name="quantity" placeholder="{{ trans('contents.common.form.quantity') }}"
                                        value="{{ old('quantity') }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary"
                                type="submit">{{ trans('contents.common.form.add_detail') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('contents.host.detail') }}</h3>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{ trans('contents.common.table.number') }}</th>
                                    <th>{{ trans('contents.common.table.province') }}</th>
                                    <th>{{ trans('contents.common.table.car_type') }}</th>
                                    <th>{{ trans('contents.common.table.quantity') }}</th>
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
    <div class="modal fade" id="modal-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('contents.host.detail') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">{{ trans('contents.common.x') }}</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2">{{ trans('contents.common.form.province') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" disabled id="detail-province" name="province_id">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2">{{ trans('contents.common.table.car_type') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" disabled id="detail-car-type" name="car_type_id">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2">{{ trans('contents.common.form.quantity') }}</label>
                                <div class="col-sm-10">
                                    <label class="error text-danger" id="error-quantity"></label>
                                    <input type="text" class="form-control" id="detail-quantity" name="quantity">
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
<script src="{{ asset('js/host/hostDetail.js') }}"></script>

@endsection

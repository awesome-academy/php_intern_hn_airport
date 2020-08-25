@extends('admin.layout')

@section('title', 'Admin Local Driver')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.admin.host') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.admin.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.admin.host') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title col-md-8">{{ trans('contents.admin.list_host') }}</h3>
                        <button type="button" class="btn btn-block btn-default col-md-2" style="float: right">{{ trans('contents.admin.add_host') }}</button>
                    </div>

                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{ trans('contents.admin.table.id') }}</th>
                                    <th>{{ trans('contents.admin.table.name') }}</th>
                                    <th>{{ trans('contents.admin.table.phone') }}</th>
                                    <th>{{ trans('contents.admin.table.avatar') }}</th>
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
</section>

<script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/bower_localdriver/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

@endsection

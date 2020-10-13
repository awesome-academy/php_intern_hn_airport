@extends('host.layout')

@section('title', 'Host Local Driver')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ trans('contents.common.notification.title') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ trans('contents.common.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('contents.common.notification.title') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-body">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title col-md-8">{{ trans('contents.common.notification.list_notification') }}</h3>
                        </div>
                        <div class="card-body">
                            <table id="table-notification-new" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ trans('contents.common.table.id') }}</th>
                                        <th>{{ trans('contents.common.table.title') }}</th>
                                        <th>{{ trans('contents.common.table.link') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $indexNew = 1; @endphp

                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ $indexNew }}</td>
                                            <td>{{ $notification->data['title'] }}</td>
                                            <td>
                                                <a href="{{ $notification->data['link'] }}">{{ $notification->data['link'] }}</a>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-noti" data-id="{{ $notification->id }}">
                                                    <i class="fas fa-check"></i>&nbsp;{{ trans('contents.common.table.read') }}</button>
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

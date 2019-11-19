@extends('layouts.app')


@section('title','ACTIVITY')


@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
@endpush


@section('content')
    <div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">ACTIVITY LOG</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                            <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Url</th>
                                <th>Method</th>
                                <th>Ip</th>
                                <th>Time</th>
                                <th>Agent</th>

                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $key=>$log)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $log->subject }}</td>
                                    <td>{{ $log->url }}</td>
                                    <td>{{ $log->method }}</td>
                                    <td>{{ $log->ip }}</td>
                                    <td>{{ $log->created_at }}</td>
                                    <td>{{ $log->agent }}</td>


                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <th>ID</th>
                            <th width="15%">Subject</th>
                            <th width="5%">Url</th>
                            <th width="5%">Method</th>
                            <th width="5%">Ip</th>
                            <th width="20%">Time</th>
                            <th width="5%">Agent</th>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@push('scripts')


        <script>
            $(document).ready(function() {

                $('#dataTable').DataTable( {

                } );
            } );
        </script>




        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

@endpush

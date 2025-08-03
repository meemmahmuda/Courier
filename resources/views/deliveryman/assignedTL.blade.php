@extends('deliveryman.index')

@section('title')
    Assigned TL
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assigned TL</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Assigned TL</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ref. No</th>
                                            <th>Zone</th>
                                            <th>Business Name</th>
                                            <th>Business Type</th>
                                            <th>Owner Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>TL Number</th>
                                            <th>Assigned Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trade_licences as $trade_licence)

                                        <tr>
                                            <td>{{ $trade_licence->ref_no}}</td>
                                            <td>{{ $trade_licence->zonename}}</td>
                                            <td>{{ $trade_licence->businame}}</td>
                                            <td>{{ $trade_licence->busitype}}</td>
                                            <td>{{ $trade_licence->OwnerName}}</td>
                                            <td>{{ $trade_licence->Mob}}</td>
                                            <td>{{ $trade_licence->busiadd}}</td>
                                            <td>{{ $trade_licence->TLNumber}}</td>
                                            <th>{{ $trade_licence->assigned_dm_date}}</th>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @endsection

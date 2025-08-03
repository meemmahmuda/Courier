@extends('supervisor.index')

@section('title')
    Delivered
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivered</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivered</li>
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
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif

                            {{-- <div class="card-header">

                            </div> --}}
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
                                            <th>DM</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>OTP Verification</th>
                                            <th>Delivery Slip</th>
                                            <th>Delivery Date</th>
                                            <th>Receiver's Photo</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($delivered as $delivery)
                                        <tr>
                                            <td>{{ $delivery->ref_no }}</td>
                                            <td>{{ $delivery->zonename }}</td>
                                            <td>{{ $delivery->businame }}</td>
                                            <td>{{ $delivery->busitype }}</td>
                                            <td>{{ $delivery->OwnerName }}</td>
                                            <td>{{ $delivery->Mob }}</td>
                                            <td>{{ $delivery->busiadd }}</td>
                                            <td>{{ $delivery->TLNumber }}</td>
                                            <td>
                                                @foreach ($dm as $deliveryman)
                                                    @if ($deliveryman->id == $delivery->assigned_dm)
                                                        {{ $deliveryman->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $delivery->latitude }}</td>
                                            <td>{{ $delivery->longitude }}</td>
                                            <td>{{ $delivery->otp_verification }}</td>
                                            <td>@if ($delivery->delivery_slip != '-')
                                                <a href="{{ asset('storage/'. $delivery->delivery_slip) }}" target="_blank">
                                                <img src="{{ asset('images/slip.png') }}" alt="slip" height="32px" width="32px"></a>
                                                @else
                                                {{ $delivery->delivery_slip }}
                                                @endif
                                                </td>
                                                <td>{{ $delivery->delivery_date }}</td>
                                            <td><a href="{{ asset('storage/'. $delivery->receivers_photo) }}" target="_blank"><img src="{{ asset('images/slip.png') }}" alt="slip" height="32px" width="32px"></a></td>
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


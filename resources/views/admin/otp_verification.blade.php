@extends('admin.index')

@section('title')
    OTP Verification Details
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>OTP Verification Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">OTP Verification Details</li>
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
                                            <th>No</th>
                                            <th>Ref. No</th>
                                            <th>Mobile</th>
                                            <th>OTP Code</th>
                                            <th>Status</th>
                                            <th>Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($otps as $otp)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $otp->ref_no }}</td>
                                            <td>{{ $otp->mobile }}</td>
                                            <td>{{ $otp->otp_code }}</td>
                                            <td>{{ $otp->verification_status }}</td>
                                            <td>{{ $otp->updated_at->format('d-m-Y h:i A') }}</td>


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

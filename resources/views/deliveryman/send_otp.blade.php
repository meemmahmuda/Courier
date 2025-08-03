@extends('deliveryman.index')

@section('title')
    Send OTP
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Send OTP</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Send OTP</li>
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
                            <div class="card-header">
                                <form action="{{ route('deliveryman.sendOtp') }}" method="POST">
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label>Ref No.</label>
                                        <input type="text" name="ref_no" class="form-control"/>
                                        @error('ref_no')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Mobile No.</label>
                                        <input type="text" name="mobile" class="form-control"/>
                                        @error('mobile')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Send OTP</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-header -->

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

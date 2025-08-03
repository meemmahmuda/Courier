@extends('deliveryman.index')

@section('title')
    Return to DNCC
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Return to DNCC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Return to DNCC</li>
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
                                <form action="{{ route('deliveryman.returned_store') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label>Ref. No</label>
                                        <input type="text" name="ref_no" class="form-control" />
                                        @error('ref_no')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>DNCC Receive Slip</label>
                                        <input type="file" name="return_slip" class="form-control" />
                                        @error('return_slip')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Status</label>
                                        <select name="delivery_status" class="form-control">
                                            <option selected disabled>Select Status</option>
                                            <option value="Returned">Returned</option>
                                        </select>
                                        @error('delivery_status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Date and Time</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" name="return_date" class="form-control datetimepicker-input"
                                                data-target="#reservationdatetime" />
                                            <div class="input-group-append" data-target="#reservationdatetime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('return_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ref. No</th>
                                            <th>Zone</th>
                                            <th>Business Name</th>
                                            <th>Business Type</th>
                                            <th>Owner</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>TL Number</th>
                                            <th>Return Date and Time</th>
                                            <th>DNCC Receive Slip</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($returned as $return)
                                        <tr>
                                            <td>{{ $return->ref_no }}</td>
                                            <td>{{ $return->zonename }}</td>
                                            <td>{{ $return->businame }}</td>
                                            <td>{{ $return->busitype }}</td>
                                            <td>{{ $return->OwnerName }}</td>
                                            <td>{{ $return->Mob }}</td>
                                            <td>{{ $return->busiadd }}</td>
                                            <td>{{ $return->TLNumber }}</td>
                                            <td>{{ $return->return_date }}</td>
                                            <td><a href="{{ asset('storage/'. $return->return_slip) }}" target="_blank"><img src="{{ asset('images/slip.png') }}" alt="slip" height="32px" width="32px"></a></td>

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


@section('customJs')
    <script>
        $(function() {
            $('#reservationdatetime').datetimepicker({
                format: 'DD-MM-YYYY hh:mm A',
                icons: {
                    time: 'far fa-clock'
                }
            });

        });
    </script>
@endsection

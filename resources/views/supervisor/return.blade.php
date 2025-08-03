@extends('supervisor.index')

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
                            <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Home</a></li>
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
                                <form action="">


                                    <div class="form-group col-md-4">
                                        <label>Zone</label>
                                        <select name="zonename" class="form-control" required>
                                            <option selected disabled>Select Zone</option>
                                            @foreach ($zones as $zone)
                                            <option value="{{ $zone }}" {{ request('zonename') == $zone ? 'selected' : '' }}>{{ $zone }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Filter</button>
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
                                            <th>Owner Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>TL Number</th>
                                            <th>SP Assign Date</th>
                                            <th>Assigned DM</th>
                                            <th>DM Assign Date</th>
                                            <th>Return Date and Time</th>
                                            <th>Return Type</th>
                                            <th>DNCC Receive Slip</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $return)

                                        <tr>
                                            <td>{{ $return->ref_no}}</td>
                                            <td>{{ $return->zonename}}</td>
                                            <td>{{ $return->businame}}</td>
                                            <td>{{ $return->busitype}}</td>
                                            <td>{{ $return->OwnerName}}</td>
                                            <td>{{ $return->Mob}}</td>
                                            <td>{{ $return->busiadd}}</td>
                                            <td>{{ $return->TLNumber}}</td>
                                            <td>{{ $return->assigned_sp_date}}</td>
                                            <td>
                                                @foreach ($deliveryman as $dm)
                                                    @if ($dm->id == $return->assigned_dm)
                                                        {{ $dm->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $return->assigned_dm_date}}</td>
                                            <td>{{ $return->return_date}}</td>
                                            <td>{{ $return->cancellation_reason}}</td>
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
                    format: 'DD-MM-YYYY',
                    icons: {
                        time: 'far fa-clock'
                    }
                });

            });
        </script>
    @endsection

@extends('supervisor.index')

@section('title')
    Delivery Report
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivery Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivery Report</li>
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
                                            <th>Supervisor Name</th>
                                            <th>Assigned Date</th>
                                            <th>Delivery Man Name</th>
                                            <th>Assigned Date</th>
                                            <th>Delivery Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $delivery_report)


                                        <tr>
                                            <td>{{ $delivery_report->ref_no }}</td>
                                            <td>{{ $delivery_report->zonename }}</td>
                                            <td>{{ $delivery_report->businame }}</td>
                                            <td>{{ $delivery_report->busitype }}</td>
                                            <td>{{ $delivery_report->OwnerName }}</td>
                                            <td>{{ $delivery_report->Mob }}</td>
                                            <td>{{ $delivery_report->busiadd }}</td>
                                            <td>{{ $delivery_report->TLNumber }}</td>
                                            <td>{{ Auth::guard('supervisor')->user()->name }}</td>
                                            <td>{{ $delivery_report->assigned_sp_date }}</td>
                                            <td>
                                                @foreach ($deliveryman as $dm)
                                                @if ($dm->id == $delivery_report->assigned_dm )
                                                    {{ $dm->name }}
                                                @endif

                                                @endforeach
                                            </td>
                                            <td>{{ $delivery_report->assigned_dm_date }}</td>
                                            <td>{{ $delivery_report->delivery_date }}</td>

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

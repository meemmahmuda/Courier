@extends('supervisor.index')

@section('title')
    Delivery Status
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivery Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivery Status</li>
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
                                        <label>Delivery Man Name</label>
                                        <select name="assigned_dm" class="form-control" id="supervisor">
                                            <option selected disabled>Select Delivery Man</option>
                                            @foreach ($deliverymans as $deliveryman)
                                                <option value="{{ $deliveryman->id }}"
                                                    {{ $deliveryman->id == request('assigned_dm') ? 'selected' : null }}>
                                                    {{ $deliveryman->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assigned_dm')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
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
                                            <th>Assigned DM</th>
                                            <th>Assigned Date</th>
                                            <th>1st Call</th>
                                            <th>Status</th>
                                            <th>2nd Call</th>
                                            <th>Status</th>
                                            <th>3rd Call</th>
                                            <th>Status</th>
                                            <th>Delivery Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_datas as $trade_licence)

                                        <tr>
                                            <td>{{ $trade_licence->ref_no}}</td>
                                            <td>{{ $trade_licence->zonename}}</td>
                                            <td>{{ $trade_licence->businame}}</td>
                                            <td>{{ $trade_licence->busitype}}</td>
                                            <td>{{ $trade_licence->OwnerName}}</td>
                                            <td>{{ $trade_licence->Mob}}</td>
                                            <td>{{ $trade_licence->busiadd}}</td>
                                            <td>{{ $trade_licence->TLNumber}}</td>
                                            <td>
                                                @foreach ($deliverymans as $deliveryman)
                                                @if ($trade_licence->assigned_dm == $deliveryman->id)
                                                {{ $deliveryman->name }}
                                                @endif
                                                @endforeach</td>
                                            <td>{{ $trade_licence->assigned_dm_date}}</td>
                                            <td>{{ $trade_licence->dm_1st_call}}</td>
                                            <td>{{ $trade_licence->dm_1st_status}}</td>
                                            <td>{{ $trade_licence->dm_2nd_call}}</td>
                                            <td>{{ $trade_licence->dm_2nd_status}}</td>
                                            <td>{{ $trade_licence->dm_3rd_call}}</td>
                                            <td>{{ $trade_licence->dm_3rd_status}}</td>
                                            <td>{{ $trade_licence->delivery_status}}</td>

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


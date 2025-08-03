@extends('deliveryman.index')

@section('title')
    Call Verification
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Call Verification</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Call Verification</li>
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
                                <form action="{{ route('deliveryman.call_store') }}" method="post">
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label>Ref. No</label>
                                        <input type="text" name="ref_no" class="form-control"/>
                                        @error('ref_no')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Call Type</label>
                                        <select name="call_type" class="form-control">
                                            <option selected disabled>Select Call Type</option>
                                            <option value="dm_1st_call">1st Time Call</option>
                                            <option value="dm_2nd_call">2nd Time Call</option>
                                            <option value="dm_3rd_call">3rd Time Call</option>
                                        </select>
                                        @error('call_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Date and Time</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" name="datetime" class="form-control datetimepicker-input"
                                                data-target="#reservationdatetime"/>
                                            <div class="input-group-append" data-target="#reservationdatetime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('datetime')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option selected disabled>Select Status</option>
                                            <option value="Success">Success</option>
                                            <option value="Failed">Failed</option>
                                        </select>
                                        @error('status')
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
                                            <th>Owner Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>TL Number</th>
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

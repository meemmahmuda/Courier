@extends('admin.index')

@section('title')
    Verified by SP
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Verified by SP</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Verified by SP</li>
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
                                <form>
                                    <div class="form-group col-md-4">
                                        <label>Supervisor Name</label>
                                        <select name="supervisor" class="form-control">
                                            <option selected disabled>Select Supervisor</option>
                                            @foreach ($select_supervisors as $select_supervisor)
                                                <option value="{{ $select_supervisor->id }}" {{ request('supervisor') == $select_supervisor->id ? 'selected' : '' }}>{{ $select_supervisor->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                            <th>1st Call by SP</th>
                                            <th>2nd Call by SP</th>
                                            <th>3rd Call by SP</th>
                                            <th>Delivery Status</th>
                                            <th>Cancellation Reason</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($verified as $verify)

                                        <tr>
                                            <td>{{ $verify->ref_no }}</td>
                                            <td>{{ $verify->zonename }}</td>
                                            <td>{{ $verify->businame }}</td>
                                            <td>{{ $verify->busitype }}</td>
                                            <td>{{ $verify->OwnerName }}</td>
                                            <td>{{ $verify->Mob }}</td>
                                            <td>{{ $verify->busiadd }}</td>
                                            <td>{{ $verify->TLNumber }}</td>
                                            <td>{{ $verify->sp_1st_status }}</td>
                                            <td>{{ $verify->sp_2nd_status }}</td>
                                            <td>{{ $verify->sp_3rd_status }}</td>
                                            <td>{{ $verify->delivery_status }}</td>
                                            <td>{{ $verify->cancellation_reason }}</td>

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

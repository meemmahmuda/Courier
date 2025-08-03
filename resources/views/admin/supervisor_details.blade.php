@extends('admin.index')

@section('title')
    Supervisor Details
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Supervisor Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Supervisor Details</li>
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
                                        <label>Supervisor Name</label>
                                        <select name="supervisor" class="form-control">
                                            <option selected disabled>Select Supervisor</option>
                                            @foreach ($select_supervisors as $select_supervisor )
                                          <option value="{{ $select_supervisor->id }}"
                                            {{ $select_supervisor->id == request('supervisor') ? 'selected' : null }}>
                                            {{ $select_supervisor->name }}</option>
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
                                            <th>Supervisor Name</th>
                                            <th>Assigned Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assign_to_sp as $assign_sp)
                                            <tr>
                                                <td>{{ $assign_sp->ref_no }}</td>
                                                <td>{{ $assign_sp->zonename }}</td>
                                                <td>{{ $assign_sp->businame }}</td>
                                                <td>{{ $assign_sp->busitype }}</td>
                                                <td>{{ $assign_sp->OwnerName }}</td>
                                                <td>{{ $assign_sp->Mob }}</td>
                                                <td>{{ $assign_sp->busiadd }}</td>
                                                <td>{{ $assign_sp->TLNumber }}</td>
                                                <td>
                                                    @foreach ($select_supervisors as $select_supervisor)
                                                    @if ($assign_sp->assigned_sp == $select_supervisor->id)
                                                    {{ $select_supervisor->name }}
                                                    @endif
                                                    @endforeach</td>
                                                <td>{{ $assign_sp->assigned_sp_date }}</td>

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

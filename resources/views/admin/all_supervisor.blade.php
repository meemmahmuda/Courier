@extends('admin.index')

@section('title')
    All Supervisor
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Supervisor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Supervisor</li>
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
                            <div class="card-header">
                                <h3 class="card-title">All Supervisor List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Zone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($supervisors as $supervisor )


                                        <tr style="color: @php
                                        if($supervisor->status != 'active')
                                        {
                                            echo "red";
                                        }

                                    @endphp">
                                            <td>{{ $supervisor->id }}</td>
                                            <td>{{ $supervisor->name }}</td>
                                            <td>{{ $supervisor->email }}</td>
                                            <td>{{ $supervisor->zone }}</td>
                                            <td>{{ $supervisor->status }}</td>

                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.sp_profile', $supervisor->id) }}" class="btn btn-success"><i class="fas fa-eye"></i></a>
                                                    {{-- <a href="#" class="btn btn-info"><i class="fas fa-edit"></i></a> --}}
                                                    <a href="{{ route('admin.sp_profile_delete', $supervisor->id) }}"
                                                        onclick="return confirm('Are you sure want to delete?');"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                  </div>
                                            </td>
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

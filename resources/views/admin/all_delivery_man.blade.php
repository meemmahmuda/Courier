@extends('admin.index')

@section('title')
    All Delivery Man
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Delivery Man</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Delivery Man</li>
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
                                <h3 class="card-title">All Delivery Man List</h3>
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
                                        @foreach ($deliveryman as $dm)
                                            <tr>
                                                <td>{{ $dm->id }}</td>
                                                <td>{{ $dm->name }}</td>
                                                <td>{{ $dm->email }}</td>
                                                <td>{{ $dm->zone }}</td>
                                                <td style="color: @php
                                                if($dm->status == 'active')
                                                {
                                                    echo "green";
                                                }
                                                else {
                                                    echo "red";
                                                }
                                            @endphp">{{ $dm->status }}</td>

                                                <td class="text-right py-0 align-middle">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('admin.dm_profile', $dm->id) }}"
                                                            class="btn btn-success"><i class="fas fa-eye"></i></a>
                                                        {{-- <a href="#" class="btn btn-info"><i
                                                                class="fas fa-edit"></i></a> --}}
                                                        <a href="{{ route('admin.dm_profile_delete', $dm->id) }}"
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

@extends('admin.index')

@section('title')
    Add Delivery Man
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Delivery Man</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create Delivery Man</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            <div class="card-header">
                                <h3 class="card-title">Delivery Man Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('delivery_man.store') }}" method="post">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <select class="form-control select2" style="width: 100%;" name="supervisor">
                                          <option selected disabled>Select Supervisor</option>
                                          @foreach ($select_supervisors as $select_supervisor )
                                          <option value="{{ $select_supervisor->zone }}">{{ $select_supervisor->name }} - ( {{ $select_supervisor->zone }} )</option>
                                          @endforeach
                                        </select>
                                        @error('supervisor')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                      </div>

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Full Name">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Email">
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1" placeholder="Password">
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" class="form-control">
                                            @error('dob')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" name="mobile" class="form-control"
                                            placeholder="Enter Mobile No">
                                            @error('mobile')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>NID</label>
                                        <input type="text" name="nid" class="form-control"
                                            placeholder="Enter NID No">
                                            @error('nid')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->



                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('customJs')
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection

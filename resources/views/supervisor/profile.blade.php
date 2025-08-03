@extends('supervisor.index')

@section('title')
    Profile
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">

                            {{ $error }}

                        </div>
                    @endforeach
                @endif

            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">


                                    @if (Auth::guard('supervisor')->user()->image)
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('storage/' . Auth::guard('supervisor')->user()->image) }}"
                                            alt="Profile Picture">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                    @endif

                                </div>

                                <h3 class="profile-username text-center">{{ Auth::guard('supervisor')->user()->name }}</h3>

                                <p class="text-muted text-center">{{ Auth::guard('supervisor')->user()->zone }}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b><i class="far fa-address-card mr-1"></i></i>ID :</b> <a
                                            class="float-right">{{ Auth::guard('supervisor')->user()->id }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b><i class="fas fa-calendar-week mr-1"></i>Joined :</b> <a
                                            class="float-right">{{ Auth::guard('supervisor')->user()->created_at->format('d M, Y') }}</a>
                                    </li>
                                </ul>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#about"
                                            data-toggle="tab">About</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">Edit</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="about">

                                        <div class="card-body">
                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                                            <p class="text-muted">{{ Auth::guard('supervisor')->user()->address }}</p>

                                            <hr>

                                            <strong><i class="fas fa-calendar mr-1"></i> Date of Birth</strong>

                                            <p class="text-muted">
                                                {{ \Carbon\Carbon::parse(Auth::guard('supervisor')->user()->dob)->format('d M, Y') }} </p>


                                            <hr>

                                            <strong><i class="fas fa-mobile mr-1"></i> Mobile</strong>

                                            <p class="text-muted">{{ Auth::guard('supervisor')->user()->mobile }}</p>


                                            <hr>

                                            <strong><i class="far fa-address-card mr-1"></i> NID</strong>

                                            <p class="text-muted">{{ Auth::guard('supervisor')->user()->nid }}</p>

                                            <hr>

                                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>

                                            <p class="text-muted">{{ Auth::guard('supervisor')->user()->email }}</p>

                                        </div>
                                        <!-- /.card-body -->


                                    </div>
                                    <!-- /.tab-pane -->


                                    <div class="tab-pane" id="edit">
                                        <form action="{{ route('supervisor.profile_update') }}" method="post"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputName"
                                                        value="{{ Auth::guard('supervisor')->user()->name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputEmail"
                                                        value="{{ Auth::guard('supervisor')->user()->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">NID</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control"
                                                        value="{{ Auth::guard('supervisor')->user()->nid }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Enter New Password">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="inputExperience"
                                                    class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="address"
                                                        value="{{ old('address', Auth::guard('supervisor')->user()->address) }}">{{ Auth::guard('supervisor')->user()->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Mobile</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="mobile"
                                                        pattern="\d{11}" maxlength="11">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Photo</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="image" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

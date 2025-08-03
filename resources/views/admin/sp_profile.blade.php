@extends('admin.index')

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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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


                                    @if ($supervisors->image && $supervisors->status == 'active')
                                        <img class="profile-user-img img-fluid img-circle" style="border: 3px solid #00ff00;"
                                            src="{{ asset('storage/' . $supervisors->image) }}"
                                            alt="Profile Picture">

                                            @elseif ($supervisors->image && $supervisors->status == 'inactive')
                                            <img class="profile-user-img img-fluid img-circle" style="border: 3px solid #ff0000;"
                                            src="{{ asset('storage/' . $supervisors->image) }}"
                                            alt="Profile Picture">

                                            @elseif(!$supervisors->image && $supervisors->status == 'inactive')
                                        <img class="profile-user-img img-fluid img-circle" style="border: 3px solid #ff0000;"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">

                                    @else
                                        <img class="profile-user-img img-fluid img-circle" style="border: 3px solid #00ff00;"
                                        src="{{ asset('dist/img/user.jpg') }}" alt="Default Profile">
                                    @endif

                                </div>

                                <h3 class="profile-username text-center" @if ($supervisors->status == 'inactive')
                                    style="{{ 'color: #ff0000;' }}"
                                @endif>{{ $supervisors->name }}</h3>

                                <p class="text-muted text-center">{{ $supervisors->zone }}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b><i class="far fa-address-card mr-1"></i></i>ID :</b> <a
                                            class="float-right">{{ $supervisors->id }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b><i class="fas fa-calendar-week mr-1"></i>Joined :</b> <a
                                            class="float-right">{{ $supervisors->created_at->format('d M, Y') }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b><i class="fas fa-truck mr-1"></i>Total Delivered :</b> <a
                                            class="float-right">{{ $total_delivered }}</a>
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

                                            <p class="text-muted">{{ $supervisors->address }}</p>

                                            <hr>

                                            <strong><i class="fas fa-calendar mr-1"></i> Date of Birth</strong>

                                            <p class="text-muted">
                                                {{ \Carbon\Carbon::parse($supervisors->dob)->format('d M, Y') }} </p>


                                            <hr>

                                            <strong><i class="far fa-address-card mr-1"></i> NID</strong>

                                            <p class="text-muted">{{ $supervisors->nid }}</p>

                                            <hr>

                                            <strong><i class="fas fa-mobile mr-1"></i> Mobile</strong>

                                            <p class="text-muted">{{ $supervisors->mobile }}</p>


                                            <hr>

                                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>

                                            <p class="text-muted">{{ $supervisors->email }}</p>

                                        </div>
                                        <!-- /.card-body -->


                                    </div>
                                    <!-- /.tab-pane -->


                                    <div class="tab-pane" id="edit">
                                        <form action="{{ route('admin.sp_profile_update',$supervisors->id) }}" method="post"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-10">
                                                    <select name="status" class="form-control">
                                                        <option selected disabled>Select Status</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputName"
                                                    name="name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputEmail"
                                                        name="email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">NID</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control"
                                                    name="nid">
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
                                                    <textarea class="form-control" name="address" placeholder="Enter Present Address"
                                                        value="{{ old('address', $supervisors->address) }}">{{ $supervisors->address }}</textarea>
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

                                            <div class="form-group">
                                                <label>Select Zone</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="১ উত্তরা" name="zone[]">
                                                    <label class="form-check-label">১ উত্তরা</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="২ মিরপুর" name="zone[]">
                                                    <label class="form-check-label">২ মিরপুর</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="৩ মহাখালী"
                                                        name="zone[]">
                                                    <label class="form-check-label">৩ মহাখালী</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="৪ মিরপুর" name="zone[]">
                                                    <label class="form-check-label">৪ মিরপুর</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="৫ কারওয়ান বাজার"
                                                        name="zone[]">
                                                    <label class="form-check-label">৫ কারওয়ান বাজার</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="৬ উত্তরা" name="zone[]">
                                                    <label class="form-check-label">৬ উত্তরা</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="৭ দক্ষিণখান"
                                                        name="zone[]">
                                                    <label class="form-check-label">৭ দক্ষিণখান</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="৮ উত্তরখান"
                                                        name="zone[]">
                                                    <label class="form-check-label">৮ উত্তরখান</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="৯ ভাটারা"
                                                        name="zone[]">
                                                    <label class="form-check-label">৯ ভাটারা</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="১০ সাতারকুল"
                                                        name="zone[]">
                                                    <label class="form-check-label">১০ সাতারকুল</label>
                                                </div>
                                                @error('zone')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

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

@extends('admin.index')

@section('title')
    TL Assign to Supervisor
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>TL Assign to Supervisor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">TL Assign to Supervisor</li>
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
                                <form action="{{ route('tl_assign_to_sp_store') }}" method="POST">
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label>Supervisor Name</label>
                                        <select name="supervisor" class="form-control" id="supervisor">
                                            <option selected disabled>Select Supervisor</option>
                                            @foreach ($supervisors as $select_supervisor)
                                                <option value="{{ $select_supervisor->id }}">{{ $select_supervisor->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supervisor')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-md-4">
                                        <label>Ref. No</label>
                                        <input type="text" name="ref_no" class="form-control" required/>
                                        @error('ref_no')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group col-md-4">
                                        <label>Zone Name</label>
                                        <select name="zonename" id="zone" class="form-control">
                                            <option>Select Zone</option>

                                        </select>
                                        @error('zonename')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Date</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" name="assigned_sp_date"
                                                class="form-control datetimepicker-input"
                                                data-target="#reservationdatetime" />
                                            <div class="input-group-append" data-target="#reservationdatetime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('assigned_sp_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Assign</button>
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
                format: 'DD-MM-YYYY'
            });

        });
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#supervisor').on('change', function() {
                const supervisor = $(this).val();

                $('#zone').html('<option value="">Loading...</option>');

                if (supervisor) {
                    $.ajax({
                        url: '{{ route('zones.get') }}',
                        type: 'GET',
                        data: {
                            supervisor: supervisor
                        },
                        success: function(zones) {
                            $('#zone').empty().append(
                                '<option value="">--Select Zone--</option>');
                            if (zones.length > 0) {
                                zones.forEach(function(zone) {
                                    $('#zone').append('<option value="' + zone.trim() +
                                        '">' + zone.trim() + '</option>');
                                });
                            } else {
                                $('#zone').append(
                                    '<option value="">No zones available</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#zone').html('<option value="">--Select Zone--</option>');
                }
            });
        });
    </script>
@endsection

@extends('supervisor.index')

@section('title')
    TL Assign to Delivery Man
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>TL Assign to Delivery Man</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('supervisor.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">TL Assign to Delivery Man</li>
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
                                <form>

                                    <div class="form-group col-md-4">
                                        <label>Zone</label>
                                        <select name="zonename" class="form-control" required>
                                            <option selected disabled>Select Zone</option>
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone }}"
                                                    {{ request('zonename') == $zone ? 'selected' : '' }}>{{ $zone }}
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
                                <form action="{{ route('supervisor.tl_assign_to_dm_store') }}" method="POST">
                                    @csrf

                                    <table id="example1" class="table table-bordered table-striped">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="select-all">
                                            <label class="form-check-label" for="select-all">Select All</label>
                                        </div>
                                        <thead>
                                            <tr>
                                                {{-- <th>Check</th> --}}
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
                                                    {{-- <td>
                                                    <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $assign_sp->ref_no }}" name="ref_no[]">
                                                    </div>
                                                </td> --}}
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input ref-checkbox" type="checkbox"
                                                                value="{{ $assign_sp->ref_no }}" name="ref_no[]">
                                                            {{ $assign_sp->ref_no }}
                                                        </div>
                                                    </td>
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
                                    <hr>

                                    <div class="form-group col-md-4">
                                        <label>Delivery Man Name</label>
                                        <select name="assigned_dm" class="form-control" id="supervisor">
                                            <option selected disabled>Select Delivery Man</option>
                                            @foreach ($deliverymans as $deliveryman)
                                                <option value="{{ $deliveryman->id }}">{{ $deliveryman->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assigned_dm')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Date</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" name="assigned_dm_date"
                                                class="form-control datetimepicker-input"
                                                data-target="#reservationdatetime" />
                                            <div class="input-group-append" data-target="#reservationdatetime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('assigned_dm_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Assign</button>
                                    </div>
                                </form>
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

    {{-- jQuery logic to handle "Select All" --}}

    <script>
        $(document).ready(function() {
            // When #select-all is clicked
            $('#select-all').click(function() {
                var isChecked = $(this).is(':checked');
                $('.ref-checkbox').prop('checked', isChecked);
            });

            // Optional: Sync "Select All" checkbox if any individual checkbox is changed
            $('.ref-checkbox').change(function() {
                if ($('.ref-checkbox:checked').length === $('.ref-checkbox').length) {
                    $('#select-all').prop('checked', true);
                } else {
                    $('#select-all').prop('checked', false);
                }
            });
        });
    </script>
@endsection

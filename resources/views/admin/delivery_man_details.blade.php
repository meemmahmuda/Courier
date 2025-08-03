@extends('admin.index')

@section('title')
    Delivery Man Details
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivery Man Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivery Man Details</li>
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
                                <form method="GET" action="{{ route('delivery_man_details') }}">
                                    <div class="form-group col-md-4">
                                        <label>Supervisor Name</label>
                                        <select name="supervisor" id="supervisor" class="form-control">
                                            <option selected disabled>Select Supervisor</option>
                                            @foreach ($select_supervisors as $select_supervisor)
                                                <option value="{{ $select_supervisor->id }}"
                                                    {{ $select_supervisor->id == request('supervisor') ? 'selected' : null }}>
                                                    {{ $select_supervisor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Delivery Man Name</label>
                                        <select name="deliveryman" id="deliveryman" class="form-control">
                                            <option selected disabled>Select Delivery Man</option>

                                            @if (request('supervisor'))
                                                @php
                                                    $supervisor = \App\Models\User::find(request('supervisor'));
                                                    $zones = $supervisor ? explode(',', $supervisor->zone) : [];
                                                    $deliverymen = \App\Models\User::where('role', 'deliveryman')
                                                        ->where(function ($query) use ($zones) {
                                                            foreach ($zones as $zone) {
                                                                $query->orWhere(
                                                                    'zone',
                                                                    'like',
                                                                    '%' . trim($zone) . '%',
                                                                );
                                                            }
                                                        })
                                                        ->get();
                                                @endphp
                                                @foreach ($deliverymen as $deliveryman)
                                                    <option value="{{ $deliveryman->id }}"
                                                        {{ $deliveryman->id == request('deliveryman') ? 'selected' : '' }}>
                                                        {{ $deliveryman->name }}
                                                    </option>
                                                @endforeach
                                            @endif

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
                                            <th>SP Assigned Date</th>
                                            <th>Delivery Man Name</th>
                                            <th>DM Assigned Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assign_to_dm as $assign_dm)
                                            <tr>
                                                <td>{{ $assign_dm->ref_no }}</td>
                                                <td>{{ $assign_dm->zonename }}</td>
                                                <td>{{ $assign_dm->businame }}</td>
                                                <td>{{ $assign_dm->busitype }}</td>
                                                <td>{{ $assign_dm->OwnerName }}</td>
                                                <td>{{ $assign_dm->Mob }}</td>
                                                <td>{{ $assign_dm->busiadd }}</td>
                                                <td>{{ $assign_dm->TLNumber }}</td>
                                                <td>
                                                    @foreach ($select_supervisors as $select_supervisor)
                                                        @if ($assign_dm->assigned_sp == $select_supervisor->id)
                                                            {{ $select_supervisor->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $assign_dm->assigned_sp_date }}</td>
                                                <td>
                                                    @foreach ($select_deliverymans as $select_deliveryman)
                                                        @if ($assign_dm->assigned_dm == $select_deliveryman->id)
                                                            {{ $select_deliveryman->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $assign_dm->assigned_dm_date }}</td>

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
        $(document).ready(function() {
            $('#supervisor').on('change', function() {
                var supervisorId = $(this).val();
                $('#deliveryman').html('<option value="">Loading...</option>');

                if (supervisorId) {
                    $.ajax({
                        url: '/admin/get-deliverymen/' + supervisorId,
                        type: 'GET',
                        success: function(data) {
                            $('#deliveryman').empty().append(
                                '<option value="">Select Delivery Man</option>');
                            $.each(data, function(key, deliveryman) {
                                $('#deliveryman').append('<option value="' + deliveryman
                                    .id + '">' + deliveryman.name + '</option>');
                            });
                        },
                        error: function() {
                            $('#deliveryman').html(
                                '<option value="">No deliverymen found</option>');
                        }
                    });
                } else {
                    $('#deliveryman').html('<option value="">Select Delivery Man</option>');
                }
            });

            // Trigger AJAX on page load if supervisor is pre-selected
            var selectedSupervisorId = $('#supervisor').val();
            var selectedDeliverymanId = "{{ request('deliveryman') }}";

            if (selectedSupervisorId && $('#deliveryman option').length <= 1) {
                $.ajax({
                    url: '/admin/get-deliverymen/' + selectedSupervisorId,
                    type: 'GET',
                    success: function(data) {
                        $('#deliveryman').empty().append(
                            '<option value="">Select Delivery Man</option>');
                        $.each(data, function(key, deliveryman) {
                            var selected = (deliveryman.id == selectedDeliverymanId) ?
                                'selected' : '';
                            $('#deliveryman').append('<option value="' + deliveryman.id + '" ' +
                                selected + '>' + deliveryman.name + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endsection

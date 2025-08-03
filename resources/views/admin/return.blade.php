@extends('admin.index')

@section('title')
    Return to DNCC
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Return to DNCC</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Return to DNCC</li>
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
                                <form action="">

                                    <div class="form-group col-md-4">
                                        <label>Zone</label>
                                        <select name="zonename" class="form-control">
                                            <option value="" disabled selected>Select Zone</option>
                                            <option value="১ উত্তরা" {{ request('zonename') == "১ উত্তরা" ? 'selected' : '' }}>১ উত্তরা</option>
                                            <option value="২ মিরপুর" {{ request('zonename') == "২ মিরপুর" ? 'selected' : '' }}>২ মিরপুর</option>
                                            <option value="৩ মহাখালী" {{ request('zonename') == "৩ মহাখালী" ? 'selected' : '' }}>৩ মহাখালী</option>
                                            <option value="৪ মিরপুর" {{ request('zonename') == "৪ মিরপুর" ? 'selected' : '' }}>৪ মিরপুর</option>
                                            <option value="৫ কারওয়ান বাজার" {{ request('zonename') == "৫ কারওয়ান বাজার" ? 'selected' : '' }}>৫ কারওয়ান বাজার</option>
                                            <option value="৬ উত্তরা" {{ request('zonename') == "৬ উত্তরা" ? 'selected' : '' }}>৬ উত্তরা</option>
                                            <option value="৭ দক্ষিণখান" {{ request('zonename') == "৭ দক্ষিণখান" ? 'selected' : '' }}>৭ দক্ষিণখান</option>
                                            <option value="৮ উত্তরখান" {{ request('zonename') == "৮ উত্তরখান" ? 'selected' : '' }}>৮ উত্তরখান</option>
                                            <option value="৯ ভাটারা" {{ request('zonename') == "৯ ভাটারা" ? 'selected' : '' }}>৯ ভাটারা</option>
                                            <option value="১০ সাতারকুল" {{ request('zonename') == "১০ সাতারকুল" ? 'selected' : '' }}>১০ সাতারকুল</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                    </div>

                                    {{-- <div class="form-group col-md-4">
                                        <label>Date</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" name="return_date" class="form-control datetimepicker-input"
                                                data-target="#reservationdatetime" required/>
                                            <div class="input-group-append" data-target="#reservationdatetime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('return_date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div> --}}

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
                                            <th>Supervisor</th>
                                            <th>Assigned SP Date</th>
                                            <th>Delivery Man</th>
                                            <th>Assigned DM Date</th>
                                            <th>Print Date</th>
                                            <th>Return Date and Time</th>
                                            <th>Return Type</th>
                                            <th>DNCC Receive Slip</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $return)
                                        <tr>
                                            <td>{{ $return->ref_no}}</td>
                                            <td>{{ $return->zonename}}</td>
                                            <td>{{ $return->businame}}</td>
                                            <td>{{ $return->busitype}}</td>
                                            <td>{{ $return->OwnerName}}</td>
                                            <td>{{ $return->Mob}}</td>
                                            <td>{{ $return->busiadd}}</td>
                                            <td>{{ $return->TLNumber}}</td>
                                            <td>
                                                @foreach ($supervisors as $supervisor)
                                                    @if ($supervisor->id == $return->assigned_sp)
                                                        {{ $supervisor->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $return->assigned_sp_date}}</td>
                                            <td>
                                                @foreach ($deliverymans as $deliveryman)
                                                    @if ($deliveryman->id == $return->assigned_dm)
                                                        {{ $deliveryman->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $return->assigned_dm_date}}</td>
                                            <td>{{ $return->cdate}}</td>
                                            <td>{{ $return->return_date}}</td>
                                            <td>{{ $return->cancellation_reason}}</td>
                                            <td><a href="{{ asset('storage/'. $return->return_slip) }}" target="_blank"><img src="{{ asset('images/slip.png') }}" alt="slip" height="32px" width="32px"></a></td>
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

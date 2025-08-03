@extends('deliveryman.index')

@section('title')
    Delivery Status
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivery Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivery Status</li>
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
                                <form action="{{ route('deliveryman.delivery_status_store') }}" method="post">
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label>Ref. No</label>
                                        <input type="text" name="ref_no" class="form-control"/>
                                        @error('ref_no')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Delivery Status</label>
                                        <select name="delivery_status" class="form-control">
                                            <option selected disabled>Select Status</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Out for Delivery">Out for Delivery</option>
                                            <option value="Hold">Hold</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                        @error('delivery_status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">Submit</button>
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
                                            <th>1st Call</th>
                                            <th>2nd Call</th>
                                            <th>3rd Call</th>
                                            <th>Delivery Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($delivery_status as $delivery)

                                        <tr>
                                            <td>{{ $delivery->ref_no}}</td>
                                            <td>{{ $delivery->zonename}}</td>
                                            <td>{{ $delivery->businame}}</td>
                                            <td>{{ $delivery->busitype}}</td>
                                            <td>{{ $delivery->OwnerName}}</td>
                                            <td>{{ $delivery->Mob}}</td>
                                            <td>{{ $delivery->busiadd}}</td>
                                            <td>{{ $delivery->TLNumber}}</td>
                                            <td>{{ $delivery->dm_1st_status}}</td>
                                            <td>{{ $delivery->dm_2nd_status}}</td>
                                            <td>{{ $delivery->dm_3rd_status}}</td>
                                            <td>{{ $delivery->delivery_status}}</td>

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


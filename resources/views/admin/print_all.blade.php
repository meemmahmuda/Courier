@extends('admin.index')

@section('title')
    Print All
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Trade Licence</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Trade Licence</li>
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
                                <form>
                                    <div class="form-group col-md-4">
                                        <label>Product Type</label>
                                        <select name="product_type" class="form-control">
                                            <option disabled selected>Select Product Type</option>
                                            <option value="trade_licence" {{ request('product_type') == "trade_licence" ? 'selected' : '' }}>Trade Licence</option>
                                            <option value="others" {{ request('product_type') == "others" ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Zone Name</label>
                                        <select name="zonename" class="form-control">
                                            <option disabled selected>Select Zone</option>
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

                                    {{-- <div class="form-group col-md-4">
                                        <label>Date</label>
                                       <input type="date" name="date" class="form-control"/>
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
                                            <th>Collection Amount (Delivery)</th>
                                            <th>Actual Amount (Delivery)</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($print as $print_all)

                                        <tr>
                                            <td>{{ $print_all->ref_no }}</td>
                                            <td>{{ $print_all->zonename }}</td>
                                            <td>{{ $print_all->businame }}</td>
                                            <td>{{ $print_all->busitype }}</td>
                                            <td>{{ $print_all->OwnerName }}</td>
                                            <td>{{ $print_all->Mob }}</td>
                                            <td>{{ $print_all->busiadd }}</td>
                                            <td>{{ $print_all->TLNumber }}</td>
                                            <td>{{ $print_all->collection_amount }}</td>
                                            <td>{{ $print_all->actual_amount }}</td>

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

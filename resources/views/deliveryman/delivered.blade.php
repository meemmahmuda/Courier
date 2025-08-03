@extends('deliveryman.index')

@section('title')
    Delivered
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivered</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivered</li>
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
                                <form action="{{ route('deliveryman.delivered_store') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label for="ref_no" class="form-label">Ref No:</label>
                                        <input type="text" name="ref_no" class="form-control">
                                        @error('ref_no')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label">Choose an Option:</label><br>

                                        <input type="radio" name="selection" id="otp_radio" value="otp_radio" onchange="toggleFields()">
                                        <label>OTP Verification</label>



                                        @foreach ($delivery_slip as $slip)

                                            @if ($slip)

                                                <input type="radio" name="selection" id="delivery_radio" value="delivery_radio" onchange="toggleFields()">
                                                <label>Delivery Slip</label>
                                            @endif
                                        @endforeach



                                    </div>

                                    <div class="form-group col-md-4" id="otp_verification_section" style="display: none;">
                                        <label class="form-label">OTP Verification:</label>
                                        <select name="otp_verification" id="otp_verification" class="form-control">
                                            <option value="Success">Success</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-4" id="delivery_slip_section" style="display: none;">
                                        <label class="form-label">Upload Delivery Slip:</label>
                                        <input type="file" name="delivery_slip" id="delivery_slip" class="form-control">

                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label">Latitude:</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                                        @error('latitude')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label">Longitude:</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                                        @error('longitude')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="form-label">Receiver's Photo:</label>
                                        <input type="file" name="receivers_photo" class="form-control">
                                        @error('receivers_photo')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Status</label>
                                        <select name="delivery_status" class="form-control">
                                            <option selected disabled>Select Status</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                        @error('delivery_status')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Date and Time</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" name="delivery_date" class="form-control datetimepicker-input"
                                                data-target="#reservationdatetime" />
                                            <div class="input-group-append" data-target="#reservationdatetime"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('delivery_date')
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
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>OTP Verification</th>
                                            <th>Delivery Slip</th>
                                            <th>Delivery Date</th>
                                            <th>Receiver's Photo</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($delivered as $delivery)
                                        <tr>
                                            <td>{{ $delivery->ref_no }}</td>
                                            <td>{{ $delivery->zonename }}</td>
                                            <td>{{ $delivery->businame }}</td>
                                            <td>{{ $delivery->busitype }}</td>
                                            <td>{{ $delivery->OwnerName }}</td>
                                            <td>{{ $delivery->Mob }}</td>
                                            <td>{{ $delivery->busiadd }}</td>
                                            <td>{{ $delivery->TLNumber }}</td>
                                            <td>{{ $delivery->latitude }}</td>
                                            <td>{{ $delivery->longitude }}</td>
                                            <td>{{ $delivery->otp_verification }}</td>
                                            <td>@if ($delivery->delivery_slip != '-')
                                                <a href="{{ asset('storage/'. $delivery->delivery_slip) }}" target="_blank">
                                                <img src="{{ asset('images/slip.png') }}" alt="slip" height="32px" width="32px"></a>
                                                @else
                                                {{ $delivery->delivery_slip }}
                                                @endif
                                                </td>
                                                <td>{{ $delivery->delivery_date }}</td>
                                            <td><a href="{{ asset('storage/'. $delivery->receivers_photo) }}" target="_blank"><img src="{{ asset('images/slip.png') }}" alt="slip" height="32px" width="32px"></a></td>
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
    function toggleFields() {
        const otpRadio = document.getElementById('otp_radio');
        const deliveryRadio = document.getElementById('delivery_radio');
        const otpSection = document.getElementById('otp_verification_section');
        const deliverySection = document.getElementById('delivery_slip_section');

        if (otpRadio.checked) {
            otpSection.style.display = 'block';
            deliverySection.style.display = 'none';
            document.getElementById('delivery_slip').value = '';
        } else if (deliveryRadio.checked) {
            otpSection.style.display = 'none';
            deliverySection.style.display = 'block';
            document.getElementById('otp_verification').selectedIndex = 0;
        }
    }
</script>
<script>
    $(function() {
        $('#reservationdatetime').datetimepicker({
            format: 'DD-MM-YYYY hh:mm A',
            icons: {
                time: 'far fa-clock'
            }
        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(position => {
                const latInput = document.getElementById("latitude");
                const lngInput = document.getElementById("longitude");

                if (!latInput.value || !lngInput.value) {
                    latInput.value = position.coords.latitude;
                    lngInput.value = position.coords.longitude;

                    latInput.setAttribute('readonly', true);
                    lngInput.setAttribute('readonly', true);
                }
            }, error => {
                alert("Unable to fetch your location.");
            }, {
                enableHighAccuracy: true,
                maximumAge: 0
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });
</script>
@endsection

@extends('admin.index')

@section('title')
    Map
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Map</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Map</li>
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

                            <div class="card-body">
                                {{-- <pre>{{ print_r($locations->toArray(), true) }}</pre> --}}
                               <div id="map" style="height: 600px;"></div>
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


@section('customCss')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
@endsection

@section('customJs')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([23.8103, 90.4125], 10);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 22,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var locations = @json($locations);

            locations.forEach(function(location) {
                if (location.latitude && location.longitude) {
                    let popupContent = `
                        <strong>${location.businame}</strong><br>
                        👤 Owner: ${location.OwnerName ?? 'N/A'}<br>
                        🏘️ Zone: ${location.zonename ?? 'N/A'}<br>
                        📞 Mobile: ${location.Mob ?? 'N/A'}<br>
                        🏠 Address: ${location.busiadd ?? 'N/A'}
                    `;

                    L.marker([location.latitude, location.longitude])
                        .addTo(map)
                        .bindPopup(popupContent);
                }
            });
        });
    </script>
@endsection


{{--
Open Street Map

https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png

Carto Light Map

https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png

Carto Dark Map

https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png

Carto Positron Map

https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png

--}}

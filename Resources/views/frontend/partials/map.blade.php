

@if(isset($place->address)&&!empty($place->address))
<div class="map bg-light">

    <h3 class="text-center py-4">¿Dónde está Ubicado?</h3>

    <div class="content">
        <div id="map_canvas" style="width:100%; height:314px"></div>
    </div>

</div>
@endif


@section('scripts')
    @parent
    <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css" type="text/css" />
    <script type="text/javascript">

        function initialize(){
          var map = L.map('map_canvas').setView([{{ $place->address->lat ?? '4.570868' }}, {{ $place->address->lng ?? '-74.297333' }}], 13);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(map);

          L.marker([{{ $place->address->lat ?? '4.570868' }}, {{ $place->address->lng ?? '-74.297333' }}]).addTo(map)
            .bindPopup('{{ $place->address->title ?? 'Dirección' }}')
            .openPopup();
        }

        $(document).ready(function() {
            initialize();

        });
    </script>
@stop


























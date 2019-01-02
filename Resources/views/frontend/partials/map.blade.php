

@if(isset($place->address)&&!empty($place->address))
    @php
        $address=json_decode($place->address)
    @endphp
<div class="map bg-light">

    <h3 class="text-center py-4">¿Dónde está Ubicado?</h3>

    <div class="content">
        <div id="map_canvas" style="width:100%; height:314px"></div>
    </div>

</div>
@endif


@section('scripts')
    @parent
    <script type='text/javascript'
            src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('iplaces::api')}}&extension=.js&output=embed"></script>
    <script type="text/javascript">

        var geocoder;
        var map;
        var marker;

        function initialize() {
            var latitude ={{$address->lattitude}};
            var longitude ={{$address->longitude}};
            var OLD = new google.maps.LatLng(latitude, longitude);
            var options = {
                zoom: 16,
                center: OLD,
                mapTypeId: google.maps.MapTypeId.ROADMAP,// ROADMAP | SATELLITE | HYBRID | TERRAIN
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), options);
            geocoder = new google.maps.Geocoder();
            marker = new google.maps.Marker({
                map: map,
                draggable: false,
                position: OLD
            });
        }

        $(document).ready(function() {
            initialize();

        });
    </script>
@stop


























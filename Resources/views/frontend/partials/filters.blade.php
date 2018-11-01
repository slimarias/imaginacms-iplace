<form id="filter" method="get" action="{{route('iplaces.place.index')}}">
    <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
        <li class="list-group-item d-flex justify-content-between align-items-center rounded active"
            data-toggle="collapse" href="#collapseG" role="button" aria-expanded="false"
            aria-controls="collapseG">
            Categorias
            <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
        </li>

        <div class="collapse pt-3 show" id="collapseG">

            @if(count($categories))
                @foreach($categories as $category)
                    <li class="list-group-item border-0 py-1" data-style="button">
                        {{--<label>
                            <input type="checkbox" class="hidden"
                                   name="categories[]"
                                   value="{{$category->id}}"
                                   @isset($oldCat) @if(in_array($category->id, $oldCat)) checked="checked" @endif @endisset> {{$category->title}}
                        </label> --}}
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="categories[]" id="customCheckc{{$category->id}}" value="{{$category->id}}" @isset($oldCat) @if(in_array($category->id, $oldCat)) checked="checked" @endif @endisset>
                            <label class="custom-control-label text-capitalize" for="customCheckc{{$category->id}}">{{$category->title}}</label>
                        </div>
                    </li>
                @endforeach
            @endif
            <!--<li class="list-group-item border-0 py-1">
                <a href=""><i class="fa fa-dot-circle-o text-primary mr-3"
                              aria-hidden="true"></i>
                    Vallenato</a>
            </li> -->
        </div>
    </ul>

    <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
        <li class="list-group-item d-flex justify-content-between align-items-center rounded active"
            data-toggle="collapse" href="#collapseA" role="button" aria-expanded="false"
            aria-controls="collapseA">
            Artistas musicales
            <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
        </li>
        <div class="collapse pt-3 show" id="collapseA">
            @if(count($services))
                @foreach($services as $service)
                    <li class="list-group-item border-0 py-1" data-style="button">
                       {{--  <label>
                            <input type="checkbox" class="flat-blue jsInherit"
                                   name="services[]"
                                   value="{{$service->id}}"
                                   @isset($oldServ) @if(in_array($service->id, $oldServ)) checked="checked" @endif @endisset> {{$service->title}}
                        </label>--}}
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="services[]" id="customChecks{{$service->id}}" value="{{$service->id}}" @isset($oldServ) @if(in_array($service->id, $oldServ)) checked="checked" @endif @endisset>
                            <label class="custom-control-label text-capitalize" for="customChecks{{$service->id}}">{{$service->title}}</label>
                        </div>
                    </li>
                @endforeach
            @endif
            <!--<li class="list-group-item"><a href="">Vestibulum at eros</a></li> -->
        </div>
    </ul>

    <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
        <li class="list-group-item d-flex justify-content-between align-items-center rounded active"
            data-toggle="collapse" href="#collapseS" role="button" aria-expanded="false"
            aria-controls="collapseS">
            Shows y Espectáculos
            <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
        </li>
        <div class="collapse pt-2 show" id="collapseS">
            @if(count($zones))
                @foreach($zones as $zone)
                    <li class="list-group-item border-0 py-1" data-style="button">
                        {{-- <label>
                            <input type="checkbox" class="flat-blue jsInherit"
                                   name="zones[]"
                                   value="{{$zone->id}}"
                                   @isset($oldZone) @if(in_array($zone->id, $oldZone)) checked="checked" @endif @endisset> {{$zone->title}}
                        </label> --}}
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="zones[]" id="customCheckz{{$zone->id}}" value="{{$zone->id}}" @isset($oldZone) @if(in_array($zone->id, $oldZone)) checked="checked" @endif @endisset>
                            <label class="custom-control-label text-capitalize" for="customCheckz{{$zone->id}}">{{$zone->title}}</label>
                        </div>
                    </li>
                @endforeach
            @endif
            <!--<li class="list-group-item"><a href="">Vestibulum at eros</a></li>-->
        </div>
    </ul>
</form>

@section('scripts')
    @parent

    <script>
        $(document).ready(function () {
            $('input[type="checkbox"], input[type="radio"]').on('change', function () {
                $("#filter").submit();
            });
        });

    </script>

@stop
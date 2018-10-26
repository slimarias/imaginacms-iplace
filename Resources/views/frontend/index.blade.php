@extends('layouts.master')

@section('meta')

    @if(isset($category->title) && !empty($category->title))
        @include('iplaces::frontend.metadatacategory')
    @else
        @include('iplaces::frontend.metadataindex')
    @endif
@stop

@section('title')
    {{ $category->title ?? "Lugares" }} | @parent
@stop

@section('content')

    <div class="layout-artists">
        <div class="banner">
            <div class="container">
                <div class="row justify-content-start align-items-end">
                    <div class="col-md-12 col-lg-6">
                        <div class="text-white my-0">
                            ¿Necesitas contratar artistas o músicos para tu próximo eventos?
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-light pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-auto ml-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent mb-5">
                                <li class="breadcrumb-item"><a class="text-primary" href="{{ URL::to('/') }}">Inicio</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Artista</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12 text-center msn">
                        <p>Para que tus eventos sean los más recordados, consulta nuestro directorio de artistas
                            exclusivos y elige el que más te guste. San Agustín trae los mejores artistas de todos los
                            géneros, grupos musicales, bandas, imitadores y muchos más.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-7 col-lg-8">

                        <div class="row">

                            @if(count($places))
                                @foreach($places as $place)
                                    <div class="col-lg-6">
                                        <div class="card mb-5 px-2 pt-4 shadow-sm">
                                            <a href="{{$place->url}}">
                                                <div class="img-artista">
                                                    <img class="card-img-top" src="{{ $place->mediumimage}}"
                                                         alt="Card image cap">
                                                </div>
                                                <div class="card-body p-0">
                                                    <h5 class="card-title text-center my-3">{{ $place->title}}</h5>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                    <div class="col-md-5 col-lg-4">
                        <form id="filter" method="get" action="{{route('iplaces.place.index')}}">
                            <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
                                <li class="list-group-item d-flex justify-content-between align-items-center rounded active"
                                    data-toggle="collapse" href="#collapseG" role="button" aria-expanded="false"
                                    aria-controls="collapseG">
                                    Categorias
                                    <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
                                </li>

                                <div class="collapse pt-3" id="collapseG">

                                    @if(count($categories))
                                        @foreach($categories as $category)
                                            <li class="list-group-item border-0 py-1 border-0 py-1" data-style="button">
                                                <label>
                                                    <input type="checkbox" class="hidden"
                                                           name="categories[]"
                                                           value="{{$category->id}}"
                                                           @isset($oldCat) @if(in_array($category->id, $oldCat)) checked="checked" @endif @endisset> {{$category->title}}
                                                </label>
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="list-group-item border-0 py-1">
                                        <a href=""><i class="fa fa-dot-circle-o text-primary mr-3"
                                                      aria-hidden="true"></i>
                                            Vallenato</a>
                                    </li>
                                </div>
                            </ul>

                            <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
                                <li class="list-group-item d-flex justify-content-between align-items-center rounded active"
                                    data-toggle="collapse" href="#collapseA" role="button" aria-expanded="false"
                                    aria-controls="collapseA">
                                    Artistas musicales
                                    <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
                                </li>
                                <div class="collapse show" id="collapseA">
                                    @if(count($services))
                                        @foreach($services as $service)
                                            <li class="list-group-item border-0 py-1 border-0 py-1" data-style="button">
                                                <label>
                                                    <input type="checkbox" class="flat-blue jsInherit"
                                                           name="services[]"
                                                           value="{{$service->id}}"
                                                           @isset($oldServ) @if(in_array($service->id, $oldServ)) checked="checked" @endif @endisset> {{$service->title}}
                                                </label></li>
                                        @endforeach
                                    @endif
                                    <li class="list-group-item"><a href="">Vestibulum at eros</a></li>
                                </div>
                            </ul>

                            <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
                                <li class="list-group-item d-flex justify-content-between align-items-center rounded active"
                                    data-toggle="collapse" href="#collapseS" role="button" aria-expanded="false"
                                    aria-controls="collapseS">
                                    Shows y Espectáculos
                                    <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
                                </li>
                                <div class="collapse show" id="collapseS">
                                    @if(count($zones))
                                        @foreach($zones as $zone)
                                            <li class="list-group-item border-0 py-1 border-0 py-1" data-style="button">
                                                <label>
                                                    <input type="checkbox" class="flat-blue jsInherit"
                                                           name="zones[]"
                                                           value="{{$zone->id}}"
                                                           @isset($oldZone) @if(in_array($zone->id, $oldZone)) checked="checked" @endif @endisset> {{$zone->title}}
                                                </label></li>
                                        @endforeach
                                    @endif
                                    <li class="list-group-item"><a href="">Vestibulum at eros</a></li>
                                </div>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

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




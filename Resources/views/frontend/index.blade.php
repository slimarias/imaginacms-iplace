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
                        @include('iplaces::frontend.partials.filters')
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop




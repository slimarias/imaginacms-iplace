@extends('layouts.master')

@section('meta')
    @include('iplaces::frontend.metadatashow')
@stop

@section('title')
    {{ $place->title }} | @parent
@stop

@section('content')
    <div class="layout-artists">
        <div class="contacto">
            <a href="">
                <img class="img-fluid" src="{{ Theme::url('img/whatsapp.png') }}">
            </a>
        </div>
        <div class=" pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-auto ml-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent my-5">
                                <li class="breadcrumb-item"><a class="text-primary" href="{{ URL::to('/') }}">Inicio</a>
                                </li>
                                <li class="breadcrumb-item"><a class="text-primary"
                                                               href="{{url($place->category->url)}}">{{$place->category->title}}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{$place->title}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-7 col-lg-8 pb-5">

                        <div class="show-artist">
                            <p class="category"><strong
                                        class="text-primary">Categoría:</strong> {{$place->category->title}}</p>
                            <h1 class="mb-4"><strong class="text-primary">Nombre:</strong> {{$place->title}}</h1>

                            <div class="img-artist mb-4">
                                <img class="img-fluid w-100" src="{{ Theme::url('img/artista.jpg') }}"
                                     alt="Card image cap">
                            </div>

                            <div class="bg-light p-4 mb-4">
                                <p class="text-primary sub-title mb-1">Servicios que Ofrece:</p>
                                <p>
                                    @if(count($place->sevices))
                                        @foreach($place->sevices as $index=>$psevice)
                                            {{$psevice->title}} @if($index !==end($place->sevices)),@endif
                                        @endforeach
                                    @endif
                                </p>
                                <div class="border px-2 py-4 text-center mx-4 mt-4 mb-3">
                                    <div class="row">
                                        <div class="col border-right">
                                            <p class="sub-title my-0 text-primary">Estilo</p>
                                            <p>{{$place->stile??''}}</p>
                                        </div>
                                        <div class="col">
                                            <p class="sub-title my-0 text-primary">Tipo</p>
                                            <p>{{$place->type??''}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-primary sub-title">Descripción:</p>
                            <div class="text-justify mb-4">
                                {!!$place->description!!}
                            </div>

                            <!-- gallery image -->
                        @include('iplaces::frontend.partials.image')

                        <!-- gallery video -->
                            @include('iplaces::frontend.partials.video')

                            <div class="bg-light p-4 text-center">
                                <h2 class="mb-3">¿QUIÉRES CONTACTAR ESTE ARTISTA?</h2>
                                <a href="{{url('contacto')}}" class="btn btn-primary">Click Aquí </a>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-5 col-lg-4">
                        @include('iplaces::frontend.partials.filters')
                        <ul class="list-group ml-0 ml-lg-5 mb-5 list-featured">
                            <li class="list-group-item bg-dark text-white">Artistas Destacados</li>
                            <!-- owl vertical -->
                            @include('iplaces::frontend.partials.featured')
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop





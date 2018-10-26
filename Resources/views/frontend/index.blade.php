@extends('layouts.master')

@section('meta')
    @if(isset($category->title) && !empty($category->title))
    @include('iplaces::frontend.metadatacategory)
@else
        @include('iplaces::frontend.metadataindex)
    @endif
@stop

@section('title')
    {{ $category->title??'Lugares' }} | @parent
@stop

@section('content')
    <div class="layout-artists">

        <div class="contacto">
            <a href="">
                <img class="img-fluid" src="{{ Theme::url('img/whatsapp.png') }}">
            </a>
        </div>

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
                                <li class="breadcrumb-item"><a class="text-primary" href="{{ URL::to('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Artista</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12 text-center msn">
                        <p>Para que tus eventos sean los más recordados, consulta nuestro directorio de artistas exclusivos y elige el que más te guste. San Agustín trae los mejores artistas de todos los géneros, grupos musicales, bandas, imitadores y muchos más.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-7 col-lg-8">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-5 px-2 pt-4 shadow-sm">
                                    <a href="">
                                        <div class="img-artista">
                                            <img class="card-img-top" src="{{ Theme::url('img/artista.jpg') }}" alt="Card image cap">
                                        </div>
                                        <div class="card-body p-0">
                                            <h5 class="card-title text-center my-3">Card title</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-5 px-2 pt-4 shadow-sm">
                                    <a href="">
                                        <div class="img-artista">
                                            <img class="card-img-top" src="{{ Theme::url('img/artista.jpg') }}" alt="Card image cap">
                                        </div>
                                        <div class="card-body p-0">
                                            <h5 class="card-title text-center my-3">Card title</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-5 px-2 pt-4 shadow-sm">
                                    <a href="">
                                        <div class="img-artista">
                                            <img class="card-img-top" src="{{ Theme::url('img/artista.jpg') }}" alt="Card image cap">
                                        </div>
                                        <div class="card-body p-0">
                                            <h5 class="card-title text-center my-3">Card title</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-5 col-lg-4">

                        <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded active" data-toggle="collapse" href="#collapseG" role="button" aria-expanded="false" aria-controls="collapseG">
                                Género Musical
                                <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
                            </li>
                            <div class="collapse pt-3" id="collapseG">
                                <li class="list-group-item border-0 py-1">
                                    <a href=""><i class="fa fa-dot-circle-o text-primary mr-3" aria-hidden="true"></i> Salsa</a>
                                </li>
                                <li class="list-group-item border-0 py-1">
                                    <a href=""><i class="fa fa-dot-circle-o text-primary mr-3" aria-hidden="true"></i> Urbano</a>
                                </li>
                                <li class="list-group-item border-0 py-1">
                                    <a href=""><i class="fa fa-dot-circle-o text-primary mr-3" aria-hidden="true"></i> Pop</a>
                                </li>
                                <li class="list-group-item border-0 py-1">
                                    <a href=""><i class="fa fa-dot-circle-o text-primary mr-3" aria-hidden="true"></i> Urbano</a>
                                </li>
                                <li class="list-group-item border-0 py-1">
                                    <a href=""><i class="fa fa-dot-circle-o text-primary mr-3" aria-hidden="true"></i> Vallenato</a>
                                </li>
                            </div>
                        </ul>

                        <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded active" data-toggle="collapse" href="#collapseA" role="button" aria-expanded="false" aria-controls="collapseA">
                                Artistas musicales
                                <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
                            </li>
                            <div class="collapse show" id="collapseA">
                                <li class="list-group-item"><a href="">Dapibus ac facilisis in</a></li>
                                <li class="list-group-item"><a href="">Morbi leo risus</a></li>
                                <li class="list-group-item"><a href="">Porta ac consectetur ac</a></li>
                                <li class="list-group-item"><a href="">Vestibulum at eros</a></li>
                            </div>
                        </ul>

                        <ul class="list-group list-group-flush ml-0 ml-lg-5 mb-5">
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded active" data-toggle="collapse" href="#collapseS" role="button" aria-expanded="false" aria-controls="collapseS">
                                Shows y Espectáculos
                                <span class="badge badge-pill"><i class="fa fa-chevron-down"></i></span>
                            </li>
                            <div class="collapse show" id="collapseS">
                                <li class="list-group-item"><a href="">Dapibus ac facilisis in</a></li>
                                <li class="list-group-item"><a href="">Morbi leo risus</a></li>
                                <li class="list-group-item"><a href="">Porta ac consectetur ac</a></li>
                                <li class="list-group-item"><a href="">Vestibulum at eros</a></li>
                            </div>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </div>
@stop









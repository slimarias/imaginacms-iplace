@extends('layouts.master')

@section('meta')
@include('iplaces::frontend.metadatashow)
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
                                <li class="breadcrumb-item"><a class="text-primary" href="{{ URL::to('/') }}">Inicio</a></li>
                                <li class="breadcrumb-item"><a class="text-primary" href="{{url('/artists')}}">Artist</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Yo Me Llamo Marc Anthony 2017</li>
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
                            <p class="category"><strong class="text-primary">Categoría:</strong> Imitadores</p>
                            <h1 class="mb-4"><strong class="text-primary">Nombre:</strong> Yo Me Llamo Marc Anthony 2017 (Dany Aces)</h1>

                            <div class="img-artist mb-4">
                                <img class="img-fluid w-100" src="{{ Theme::url('img/artista.jpg') }}" alt="Card image cap">
                            </div>

                            <div class="bg-light p-4 mb-4">
                                <p class="text-primary sub-title mb-1">Servicios que Ofrece:</p>
                                <p>Música para bodas, Fiestas de 15 Años, recepción, banquete, para bailar, despedidas de soltero, Activaciones de marca, Eventos Empresariales.</p>
                                <div class="border px-2 py-4 text-center mx-4 mt-4 mb-3">
                                    <div class="row">
                                        <div class="col border-right">
                                            <p class="sub-title my-0 text-primary">Estilo</p>
                                            <p>Salsa / Pop</p>
                                        </div>
                                        <div class="col">
                                            <p class="sub-title my-0 text-primary">Tipo</p>
                                            <p>Solista</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="text-primary sub-title">Descripción:</p>
                            <div class="text-justify mb-4">
                                <p><strong>Daniel Fernando Acevedo Saldarriaga</strong> nació en el Municipio de Itagüí. Comparte su amor por la música con su hermano Santiago y su Padre, descubrió la música desde los 4 años, a los 9 perteneció al coro de la iglesia.
                                    En el 2002 tuvo la oportunidad de grabar el Himno Nacional para la posesión del ex-presidente Álvaro Uribe. Dejo el cantó un tiempo por la timidez, pero más adelante renovó su amor por la música. Desde el 2016 empezó a realizar tributos al artista salsero Marc Anthony, tuvo una aceptación tan inmensa del público el cual en el 2017 lo llevo a participar en el Reality  donde fue finalista.
                                    Cuenta con un gran prestigio y respeto por su pasión, plasmado en cada show, su entrega total, dentro y fuera del escenario, lo que le ha permitido ganarse un lugar muy especial en los corazones y amantes del género de la salsa. Ofrece un show musical de una hora y 30 minutos con 2 formatos: Pista y orquesta, que hacen una puesta en escena que hará gozar a todo el público, con temas originales y tributo a Marc Anthony. De igual manera, su repertorio incluye covers muy reconocidos que interpreta impregnando su estilo propio y siempre acompañado de 2 hermosas bailarinas.	</p>
                            </div>

                            <!-- gallery image -->
                        @include('iplaces::frontend.partials.image')

                        <!-- gallery video -->
                            @include('iplaces::frontend.partials.video')

                            <div class="bg-light p-4 text-center">
                                <h2 class="mb-3">¿QUIÉRES CONTACTAR ESTE ARTISTA?</h2>
                                <a href="" class="btn btn-primary">Click Aquí </a>
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
                            <div class="collapse" id="collapseA">
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





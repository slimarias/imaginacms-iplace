@php
    $otherplaces = get_places(['exclude' => ['places' => $place->id]]);
@endphp
<div class="places">
    <div class="container">
        <div class="row">
            <div class="col-12 pb-5">
                <hr class="my-5">
                <h3 class="text-center mb-4">..Otros lugares que te pueden interesar...</h3>

                <div id="otherplaces" class="owl-carousel owl-theme owl-places">
                    @foreach($otherplaces as $p)
                    <div class="item">
                        <a href="{{url('/lugares/'.$p->category->slug.'/'.$p->slug)}}">
                            @if(isset($p->options->mainimage)&&!empty($p->options->mainimage))
                                <img class="img-fluid w-100" src="{{url(str_replace('.jpg','_mediumThumb.jpg',$p->options->mainimage))}}"
                                     alt="{{$p->title}}"/>
                            @else
                                <img class="img-fluid w-100"
                                     src="{{url('modules/iblog/img/post/default.jpg')}}"
                                     alt="{{$p->title}}"/>
                            @endif
                            <hr class="border-primary">
                            <h4>{{$p->title}}</h4>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

@section('scripts-owl')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {
            var owl = $('#otherplaces');

            owl.owlCarousel({
                margin: 10,
                nav: true,
                dots: false,
                loop: true,
                lazyContent: true,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
        });
    </script>
@stop


























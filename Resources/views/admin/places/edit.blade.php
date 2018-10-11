@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('iplaces::places.title.edit place') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.iplaces.place.index') }}">{{ trans('iplaces::places.title.places') }}</a></li>
        <li class="active">{{ trans('iplaces::places.title.edit place') }}</li>
    </ol>
@stop

@section('content')

    {!! Form::open(['route' => ['admin.iplaces.place.update', $place->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div class="nav-tabs-custom">
                            @include('partials.form-tab-headers')
                            <div class="tab-content">
                                <?php $i = 0; ?>
                                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                                    <?php $i++; ?>
                                    <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                        @include('iplaces::admin.places.partials.edit-fields', ['lang' => $locale])
                                    </div>
                                @endforeach
                            </div> {{-- end nav-tabs-custom --}}
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                        </div>
                        <div class="box-body ">
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.iplaces.place.index')}}">
                                    <i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                            </div>
                            {{-- <div class="form-group">
                                 <label for="exampleInputEmail1 ">Email address</label>
                                 <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                             </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>{{trans('iplaces::places.title.categories')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <label for="categories"><strong>{{trans('iplaces::places.form.principal')}}</strong></label>
                            <select class="form-control" name="category_id">
                                @if(count($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}"> {{$category->title}}
                                        </option>
                                    @endforeach
                                @endif
                            </select><br>
                        </div>
                        <div class="box-body">
                            @include('iplaces::admin.fields.checklist.parent')
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <label>{{trans('iplaces::status.title')}}</label>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body ">
                            <div class='form-group{{ $errors->has("status") ? ' has-error' : '' }}'>
                                <label class="radio" for="{{trans('iplaces::status.inactive')}}">
                                    <input type="radio" id="status" name="status" value="0" checked>
                                    {{trans('iplaces::status.inactive')}}
                                </label>
                                <label class="radio" for="{{trans('iplaces::status.active')}}">
                                    <input type="radio" id="status" name="status" value="1">
                                    {{trans('iplaces::status.active')}}
                                </label>
                            </div>
                            {{-- <div class="form-group">
                                 <label for="exampleInputEmail1 ">Email address</label>
                                 <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                             </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                            </div>
                            <div class="box-body">
                                @include('iplaces::admin.fields.image',['entity'=>$place])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                            </div>
                            <div class="box-body">
                                @include('iplaces::admin.fields.maps',['field'=>['name'=>'address', 'label'=>trans('iplaces::places.form.address'),'value'=>$place->address]])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <label>User</label>
                        </div>
                        <div class="box-body">
                            <select name="user_id" id="user" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{$user->id }}" {{$user->id == $currentUser->id ? 'selected' : ''}}>{{$user->present()->fullname()}}
                                        - ({{$user->email}})
                                    </option>
                                @endforeach
                            </select><br>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.iplaces.place.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"], input[type="radio"]').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
            $('.btn-box-tool').click(function(e){
                e.preventDefault();
            });

        });

    </script>
    <style>

        .nav-tabs-custom > .nav-tabs > li.active {
            border-top-color:white !important;
            border-bottom-color: #3c8dbc !important;
        }
        .nav-tabs-custom > .nav-tabs > li.active > a, .nav-tabs-custom > .nav-tabs > li.active:hover > a {
            background-color: aliceblue !important;

        }
    </style>
@endpush


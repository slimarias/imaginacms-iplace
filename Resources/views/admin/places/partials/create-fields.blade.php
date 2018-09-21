<div class="box-body">
    <div class='form-group{{ $errors->has("$lang.title") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('iplaces::places.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("$lang.title"), ['class' => 'form-control', 'placeholder' => trans('iplaces::places.form.title')]) !!}
        {!! $errors->first("$lang.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.description") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[description]", trans('iplaces::places.form.description')) !!}
        {!! Form::textarea("{$lang}[description]", old("$lang.description"), ['class' => 'form-control',  'rows' => 3, 'placeholder' => trans('iplaces::places.form.description')]) !!}
        {!! $errors->first("$lang.description", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.slug") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[slug]", trans('iplaces::places.form.slug')) !!}
        {!! Form::text("{$lang}[slug]", old("$lang.slug"), ['class' => 'form-control', 'placeholder' => trans('iplaces::places.form.slug')]) !!}
        {!! $errors->first("$lang.slug", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.summary") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[summary]", trans('iplaces::places.form.summary')) !!}
        {!! Form::textarea("{$lang}[summary]", old("$lang.summary"), ['class' => 'form-control', 'placeholder' => trans('iplaces::places.form.summary')]) !!}
        {!! $errors->first("$lang.summary", '<span class="help-block">:message</span>') !!}
    </div>

</div>

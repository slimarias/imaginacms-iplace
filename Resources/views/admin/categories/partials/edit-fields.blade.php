<div class="box-body">
    <div class='form-group{{ $errors->has("$lang.title") ? ' has-error' : '' }}'>
        @php $oldTitle = $categories->translate($lang)->title ?? ''@endphp
        {!! Form::label("{$lang}[title]", trans('iplaces::categories.form.title')) !!}
        {!! Form::text("{$lang}[title]", old("$lang.title",$oldTitle), ['class' => 'form-control', 'placeholder' => trans('iplaces::categories.form.title')]) !!}
        {!! $errors->first("$lang.title", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("$lang.description") ? ' has-error' : '' }}'>
        @php $oldDescription = $places->translate($lang)->description ?? ''@endphp
        {!! Form::label("{$lang}[description]", trans('iplaces::categories.form.description')) !!}
        {!! Form::textarea("{$lang}[description]", old("$lang.description",$oldDescription), ['class' => 'form-control',  'rows' => 3, 'placeholder' => trans('iplaces::categories.form.description')]) !!}
        {!! $errors->first("$lang.description", '<span class="help-block">:message</span>') !!}
    </div>
</div>

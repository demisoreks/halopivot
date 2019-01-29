<div class="form-group row">
    {!! Form::label('order_no', 'Order No. *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::number('order_no', $value = null, ['class' => 'form-control', 'placeholder' => 'Order Number', 'required' => true, 'maxlength' => 10]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('title', 'Title *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('title', $value = null, ['class' => 'form-control', 'placeholder' => 'Title', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('url', 'URL *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('url', $value = null, ['class' => 'form-control', 'placeholder' => 'URL', 'required' => true, 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
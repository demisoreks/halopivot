@extends('access.app', ['page_title' => 'General Links'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('general_links.index') }}"><i class="fas fa-list"></i> Existing General Links</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit General Link</legend>
        {!! Form::model($general_link, ['route' => ['general_links.update', $general_link->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('access/general_links/form', ['submit_text' => 'Update General Link'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
@extends('access.app', ['page_title' => 'Employees'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('employees.index') }}"><i class="fas fa-list"></i> Existing Employees</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Employee</legend>
        {!! Form::model($employee, ['route' => ['employees.update', $employee->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('access/employees/form', ['submit_text' => 'Update Employee'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
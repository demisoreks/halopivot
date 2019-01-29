@extends('access.app', ['page_title' => 'Access Control', 'more' => 2])

@section('content')
@include('commons.message')
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <a href="{{ route('employees.index') }}">
                    <h1 class="text-info"><i class="fas fa-user"></i></h1>
                    <h3 class="text-info">Employees</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <a href="{{ route('privileged_links.index') }}">
                    <h1 class="text-info"><i class="fas fa-link"></i></h1>
                    <h3 class="text-info">Privileged Links</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <a href="{{ route('general_links.index') }}">
                    <h1 class="text-info"><i class="fas fa-link"></i></h1>
                    <h3 class="text-info">General Links</h3>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
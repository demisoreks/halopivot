@extends('access.app', ['page_title' => 'Access Control', 'more' => 2])

<?php
use GuzzleHttp\Client;

$client = new Client();
$res = $client->request('GET', DB::table('acc_config')->whereId(1)->first()->master_url.'/api/getRoles', [
    'query' => [
        'username' => Session::get('halo_user')->username,
        'link_id' => 1
    ]
]);
$permissions = json_decode($res->getBody());
?>
@section('content')
@include('commons.message')

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center" style="padding: 70px 20px;">
                <h3 class="text-secondary">{{ App\AccEmployee::where('active', true)->count() }} / {{ App\AccEmployee::all()->count() }}</h3>
                <h3 class="text-secondary">Active/All</h3>
                <h1 class="text-primary display-1"><i class="fas fa-user"></i></h1>
                <h1 class="text-primary">Employees</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center" style="padding: 70px 20px;">
                <h3 class="text-secondary">{{ App\AccPrivilegedLink::where('active', true)->count() }} / {{ App\AccPrivilegedLink::all()->count() }}</h3>
                <h3 class="text-secondary">Active/All</h3>
                <h1 class="text-primary display-1"><i class="fas fa-link"></i></h1>
                <h1 class="text-primary">Privileged Links</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center" style="padding: 70px 20px;">
                <h3 class="text-secondary">{{ App\AccGeneralLink::where('active', true)->count() }} / {{ App\AccGeneralLink::all()->count() }}</h3>
                <h3 class="text-secondary">Active/All</h3>
                <h1 class="text-primary display-1"><i class="fas fa-link"></i></h1>
                <h1 class="text-primary">General Links</h1>
            </div>
        </div>
    </div>
</div>
@endsection
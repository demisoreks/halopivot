@extends('app', ['page_title' => 'Dashboard'])

@section('content')
@include('commons.message')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Project Tracker</h5>
            </div>
            <div class="card-body" style="height: 524px; overflow-y: scroll;">
                <h6 class="text-center"><a href="#">Download Full Project Tracker</a></h6>
                <span class="text-center">
                    <span class="text-info">On track</span> | <span class="text-warning">Requires attention</span> | <span class="text-danger">Overdue</span> | <span class="text-success">Completed</span>
                </span>
                Project 1
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                Project 2
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
                Project 3
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                </div>
                Project 4
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100">92%</div>
                </div>
                Project 5
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 51%" aria-valuenow="51" aria-valuemin="0" aria-valuemax="100">51%</div>
                </div>
                Project 6
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                </div>
                Project 7
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                </div>
                Project 8
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
                </div>
                Project 9
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>OPCOs Performance Summary</h5>
                    </div>
                    <div class="card-body">
                        <div id="opco-performance" style="width: 100%; height: 200px;"></div>
                        @columnchart('Performance', 'opco-performance')
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>EXCO Resolutions</h5>
                    </div>
                    <div class="card-body" style="height: 200px; overflow-y: scroll;">
                        List
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Policies</h5>
                    </div>
                    <div class="card-body" style="height: 200px; overflow-y: scroll;">
                        List
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
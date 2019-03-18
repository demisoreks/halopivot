@extends('app', ['page_title' => 'Dashboard'])

@section('content')
@include('commons.message')
<div class="row">
    <div class="col-lg-4">
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-header bg-white">
                <strong>PROJECT TRACKER</strong>
            </div>
            <div class="card-body" style="height: 519px; overflow-y: scroll;">
                <!--<h6 class="text-center"><a href="#">Download Full Project Tracker</a></h6>-->
                <p>
                    <span class="text-center">
                        <span class="text-info">On track</span> | <span class="text-danger">Overdue</span>
                    </span>
                </p>
                @foreach (App\PtrProject::whereIn('status', ['A'])->orderBy('end_date')->get() as $project)
                <?php
                $class = "";
                if (date('Y-m-d') > $project->end_date)
                    $class = "progress-bar bg-danger";
                else
                    $class = "progress-bar";
                
                $total_weight = 0;
                $total_score = 0;
                /*foreach (App\PtrComponent::where('project_id', $project->id)->get() as $component) {
                    $total_weight += $component->weight;
                    $score = ($component->percentage/100)*$component->weight;
                    $total_score += $score;
                }*/
                $updates = App\PtrUpdate::where('project_id', $project->id)->orderBy('tracking_date', 'desc');
                if ($updates->count() > 0) {
                    $update = $updates->first();
                    $component_updates = json_decode($update->component_updates, true);
                    foreach ($component_updates as $component_update) {
                        $weight = App\PtrComponent::whereId($component_update['component_id'])->first()->weight;
                        $percentage = $component_update['percentage'];
                        $score = ($percentage/100)*$weight;
                        $total_score += $score;
                        $total_weight += $weight;
                    }
                }
                if ($total_weight == 0) {
                    $weighted_average = 0;
                } else {
                    $weighted_average = number_format(($total_score/$total_weight)*100);
                }
                ?>
                {{ $project->name }} - {{ $weighted_average }}%
                <div class="progress" style="margin: 0 0 10px 0;">
                    <div class="{{ $class }} progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $weighted_average }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <strong>OPCO PERFORMANCE SUMMARY</strong>
                    </div>
                    <div class="card-body">
                        <div id="opco-performance" style="width: 100%; height: 200px;"></div>
                        @columnchart('Performance', 'opco-performance')
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" style="margin-bottom: 10px;">
                <div class="card">
                    <div class="card-header bg-white">
                        <strong>EXCO RESOLUTIONS</strong>
                    </div>
                    <div class="card-body" style="height: 200px; overflow-y: scroll;">
                        List
                    </div>
                </div>
            </div>
            <div class="col-lg-6" style="margin-bottom: 10px;">
                <div class="card">
                    <div class="card-header bg-white">
                        <strong>POLICIES</strong>
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
@extends('app', ['page_title' => 'Dashboard'])

@section('content')
@include('commons.message')
@if (DB::table('acc_config')->whereId(1)->first()->show_dashboard_video)
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>{{ strtoupper(DB::table('acc_config')->whereId(1)->first()->dashboard_video_title) }}</strong>
            </div>
            <div class="card-body">
                <video class="col-12" controls autoplay>
                    <source src="{{ URL::asset('dashboard_video.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</div>
@endif
<!--
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-body">
                {{ Html::image('dashboard_banner.jpg', 'Banner', ['width' => '100%']) }}
            </div>
        </div>
    </div>
</div>
-->
@if (strpos(Session::get('halo_user')->dashboard_view, 'exco') !== false || strpos(Session::get('halo_user')->dashboard_view, 'strategy') !== false)
<div class="row">
    <div class="col-lg-4">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>PROJECT TRACKER</strong>
            </div>
            @if (strpos(Session::get('halo_user')->dashboard_view, 'exco') !== false)
            <div class="card-body" style="height: 709px; overflow-y: scroll;">
            @else
            <div class="card-body" style="height: 440px; overflow-y: scroll;">
            @endif
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
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <strong>OPCO PERFORMANCE SUMMARY</strong>
                    </div>
                    <div class="card-body">
                        <div id="performance" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active" style="height: 100%;">
                                    {!! $billing->container() !!}
                                    {!! $billing->script() !!}
                                </div>
                                <div class="carousel-item" style="height: 100%;">
                                    {!! $gross_margin->container() !!}
                                    {!! $gross_margin->script() !!}
                                </div>
                                <div class="carousel-item" style="height: 100%;">
                                    {!! $net_contribution->container() !!}
                                    {!! $net_contribution->script() !!}
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#performance" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon text-info"><h1>&lt;</h1></span>
                            </a>
                            <a class="carousel-control-next" href="#performance" role="button" data-slide="next">
                                <span class="carousel-control-next-icon text-info"><h1>&gt;</h1></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (strpos(Session::get('halo_user')->dashboard_view, 'exco') !== false)
        <div class="row">
            <div class="col-lg-6" style="margin-bottom: 20px;">
                <div class="card">
                    <div class="card-header bg-white">
                        <strong>EXCO RESOLUTIONS</strong>
                    </div>
                    <div class="card-body" style="height: 200px; overflow-y: scroll;">
                        List
                    </div>
                </div>
            </div>
            <div class="col-lg-6" style="margin-bottom: 20px;">
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
        @endif
    </div>
</div>
@endif
<?php
$mid_level = "";
if (strpos(Session::get('halo_user')->dashboard_view, 'regional-head') !== false) {
    $mid_level = "REGIONAL";
} else if (strpos(Session::get('halo_user')->dashboard_view, 'opco-head') !== false) {
    $mid_level = "OPCO";
}
if ($mid_level != "") {
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong><?php echo $mid_level ?> PERFORMANCE SUMMARY</strong>
            </div>
            <div class="card-body" style="height: 500px; overflow-y: scroll;">
                @foreach (App\AccOpco::where('supervisors', 'like', '%'.Session::get('halo_user')->username.'%')->get() as $opco)
                <table class="table table-striped table-hover" style="font-family: monospace;">
                    <tr>
                        <th width="36%"><strong>{{ $opco->title }} Financials</strong></th>
                        <th width="16%" class="text-right"><strong>{{ DB::table('tmp_fin_config')->whereId(1)->first()->current_month.' '.(DB::table('tmp_fin_config')->whereId(1)->first()->current_year - 1).' Actual' }}</strong></th>
                        <th width="16%" class="text-right"><strong>{{ DB::table('tmp_fin_config')->whereId(1)->first()->current_month.' '.(DB::table('tmp_fin_config')->whereId(1)->first()->current_year).' Actual' }}</strong></th>
                        <th width="16%" class="text-right"><strong>{{ DB::table('tmp_fin_config')->whereId(1)->first()->current_month.' '.(DB::table('tmp_fin_config')->whereId(1)->first()->current_year).' Budget' }}</strong></th>
                        <th width="16%" class="text-right"><strong>{{ 'Year '.(DB::table('tmp_fin_config')->whereId(1)->first()->current_year).' Actual' }}</strong></th>
                    </tr>
                    <tr>
                        <td class="text-left">Billing</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->previous_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_budget, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_end_budget, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Cost of Sales</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->previous_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_budget, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_end_budget, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-left"><strong>Gross Margin</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->previous_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->previous_year_month_actual), 2) }}</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_actual), 2) }}</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_budget), 2) }}</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_end_budget), 2) }}</strong></th>
                    </tr>
                    <tr>
                        <td class="text-left">Direct Overhead</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->previous_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_month_budget, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_end_budget, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Central Cost</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->previous_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_month_actual, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_month_budget, 2) }}</td>
                        <td class="text-right">{{ number_format(DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_end_budget, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-left"><strong>Net Contribution</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->previous_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->previous_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->previous_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->previous_year_month_actual), 2) }}</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_month_actual - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_month_actual), 2) }}</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_month_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_month_budget), 2) }}</strong></th>
                        <th class="text-right"><strong>{{ number_format((DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'billing')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'cost_of_sales')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'direct_overhead')->first()->current_year_end_budget - DB::table('tmp_fin_details')->where('opco_id', $opco->id)->where('line', 'central_cost')->first()->current_year_end_budget), 2) }}</strong></th>
                    </tr>
                </table>
                @endforeach
            </div>
        </div>
    </div>
    <!--
    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong><?php echo $mid_level ?> SCORECARD</strong>
            </div>
            <div class="card-body">
                <div id="mid-scorecard" style="width: 100%;"></div>
                @columnchart('Budget/Actual', 'mid-scorecard')
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>RELEVANT EXCO RESOLUTIONS</strong>
            </div>
            <div class="card-body" style="height: 240px; overflow-y: scroll;">
                List
            </div>
        </div>
    </div>
    -->
</div>
<?php
}
?>
<div class="row">
    <div class="col-lg-4">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header bg-white">
                <strong>BIRTHDAYS THIS MONTH</strong>
            </div>
            <div class="card-body" style="height: 509px; overflow-y: scroll;">
                <table class="table table-striped table-hover">
                    @foreach (DB::table('tmp_birthdays')->orderBy('day')->get() as $birthday)
                    <tr>
                        <td class="text-left" width="70%">{{ $birthday->name }}</td>
                        <td class="text-right">{{ $birthday->day }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-6">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header bg-white">
                        <strong>MEDIA</strong>
                    </div>
                    <div class="card-body text-center" style="height: 250px;">
                        <video height="205" class="col-12" controls autoplay>
                            <source src="{{ URL::asset('dashboard_video.mp4') }}" type="video/mp4">
                        </video>
                        <!--
                        <div id="media" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    {{ Html::image('images/slide/slide1.jpg', 'Slide 1', ['height' => '205']) }}
                                </div>
                                <div class="carousel-item">
                                    {{ Html::image('images/slide/slide2.jpg', 'Slide 2', ['height' => '205']) }}
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#media" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#media" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header bg-white">
                        <strong>LATEST NEWS</strong>
                    </div>
                    <div class="card-body" style="height: 250px; overflow-y: scroll;">
                        @foreach (DB::table('tmp_documents')->where('type', 'news')->orderBy('order_no', 'desc')->take(15)->get() as $document)
                        <p>
                            <a href="{{ $document->url }}" target="_blank">{{ $document->title }}</a>
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header bg-white">
                        <strong>HR POLICIES</strong>
                    </div>
                    <div class="card-body" style="height: 192px; overflow-y: scroll;">
                        @foreach (DB::table('tmp_documents')->where('type', 'hr')->orderBy('order_no')->get() as $document)
                        <p>
                            <a href="{{ $document->url }}" target="_blank">{{ $document->title }}</a>
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header bg-white">
                        <strong>ISO DOCS</strong>
                    </div>
                    <div class="card-body" style="height: 192px; overflow-y: scroll;">
                        @foreach (DB::table('tmp_documents')->where('type', 'iso')->orderBy('order_no')->get() as $document)
                        <p>
                            <a href="{{ $document->url }}" target="_blank">{{ $document->title }}</a>
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header bg-white">
                        <strong>QMS DOCS</strong>
                    </div>
                    <div class="card-body" style="height: 192px; overflow-y: scroll;">
                        @foreach (DB::table('tmp_documents')->where('type', 'qms')->orderBy('order_no')->get() as $document)
                        <p>
                            <a href="{{ $document->url }}" target="_blank">{{ $document->title }}</a>
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
	$('.carousel').carousel({
		interval: 3000,
		pause: "hover"
	});
    });
</script>
@endsection
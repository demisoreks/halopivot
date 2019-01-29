<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $page_title }} | {{ config('app.name') }}</title>
        
        {!! Html::style('css/app.css') !!}
        {!! Html::style('css/mdb.min.css') !!}
        {!! Html::style('css/datatables.min.css') !!}
        {!! Html::style('fontawesome/css/all.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
        {!! Html::script('js/datatables.min.js') !!}
        
        <script type="text/javascript">
            $(document).ready(function () {
                $('#myTable1').DataTable({
                    fixedHeader: true
                });
                $('#myTable2').DataTable({
                    fixedHeader: true
                });
                $('#myTable3').DataTable({
                    fixedHeader: true,
                    "order": [[ 0, "desc" ]]
                });
            });
            
            function confirmDisable() {
                if (confirm("Are you sure you want to disable this item?")) {
                    return true;
                } else {
                    return false;
                }
            }
            
            function confirmDelete() {
                if (confirm("Are you sure you want to completely delete this item?")) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>

        <!-- Styles -->
        
    </head>
    <?php
    $more = "";
    if (isset($nest)) {
        for ($i=0; $i<$nest; $i++) {
            $more .= "../";
        }
    }
    ?>
    <body style="background-color: white;">
        <div class="container-fluid">
            <div class="row no-gutters" style="margin: 10px 0;">
                <div class="col-md-5">{{ Html::image('images/logo.png', 'Halogen Logo', ['height' => '50px']) }}</div>
            </div>
            <div class="row bg-primary text-white" style="margin: 10px 0; padding: 5px;"><strong>{{ config('app.name') }} - Access Control</strong></div>
            <div class="row">
                <div class="col-lg-2 ">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header bg-light" id="heading1" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        Menu
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link active" href="{{ route('employees.index') }}">Employees</a>
                                        <a class="nav-link active" href="{{ route('privileged_links.index') }}">Privileged Links</a>
                                        <a class="nav-link active" href="{{ route('general_links.index') }}">General Links</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-lg-10">
                    <h1 class="page-header" style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin-bottom: 30px;">{{ $page_title }}</h1>
                    @include('commons.message')
                    @yield('content')
                </div>
            </div>
            <div class="row no-gutters" style="border-top: solid 1px #CCC; margin: 20px 0;">
                <div class="col-lg-4 offset-lg-8 justify-content-end text-right">Powered by <a href="https://halogensecurity.com" target="_blank">Strategy Hub | Halogen Security Company</a></div>
            </div>
        </div>
    </body>
</html>

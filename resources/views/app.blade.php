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
            <div class="row bg-primary">
                <div class="col-6">{{ Html::image('images/logo-new-small.jpg', 'Halogen Logo', ['height' => '70px']) }}</div>
                <div class="col-6">
                    <div class="float-right text-white" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                        {{ Session::get('halo_user')->username }}&nbsp;
                        ​<span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Html::image('images/dummy-profile.png', 'Profile picture', ['height' => '50px']) }}
                        </span>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><i class="fas fa-lock"></i> Employee Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bg-secondary text-primary" style=" margin-bottom: 20px; padding: 5px 0;">
                <div class="col-12"><strong>Welcome to {{ config('app.name') }}!</strong></div>
            </div>
            <div class="row">
                <div class="col-lg-2 ">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header bg-secondary text-primary" id="heading1" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        Privileged Links
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link active" href="#">Link 1</a>
                                        <a class="nav-link active" href="#">Link 2</a>
                                        <a class="nav-link active" href="#">Link 3</a>
                                    </nav>
                                </div>
                            </div> 
                        </div>
                        <div class="card">
                            <div class="card-header bg-secondary text-primary" id="heading2" style="padding: 0;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                        General Links
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse2" class="collapse show" aria-labelledby="heading2" data-parent="#accordion">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        @foreach (App\AccGeneralLink::where('active', true)->get() as $general_link)
                                        <a class="nav-link active" href="{{ $general_link->url }}" target="_blank">{{ $general_link->title }}</a>
                                        @endforeach
                                    </nav>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-lg-10">
                    <h1 class="page-header text-primary" style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin-bottom: 30px;">{{ $page_title }}</h1>
                    @include('commons.message')
                    @yield('content')
                </div>
            </div>
            <div class="row" style="border-top: solid 1px #CCC; margin: 20px 0;">
                <div class="col-lg-4 offset-lg-8 justify-content-end text-right">Powered by <a href="https://halogensecurity.com" target="_blank">Strategy Hub | Halogen Security Company</a></div>
            </div>
        </div>
    </body>
</html>

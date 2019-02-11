<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login | {{ config('app.name') }}</title>
        
        {!! Html::style('css/app.css') !!}
        {!! Html::style('css/mdb.min.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
        
        <style>
            #content:before {
                content: "";
                position: fixed;
                left: 0;
                right: 0;
                z-index: -1;

                display: block;
                background-image: url('images/background.jpg');
                background-size:cover;
                width: 100%;
                height: 100%;

                -webkit-filter: blur(15px);
                -moz-filter: blur(15px);
                -o-filter: blur(15px);
                -ms-filter: blur(15px);
                filter: blur(15px);
            }
        </style>
    </head>
    <body>
        <div class="container-fluid" style="height: 100vh;">
            <div class="row h-100 bg-light">
                <div class="col-10 offset-1 align-self-center">
                    <div class="row" style="height: 600px;">
                        <div class="col-lg-6 bg-primary" style="display: flex; align-items: center; justify-content: center;">
                            <div class="text-center">
                                {{ Html::image('images/logo-new.jpg', 'Halogen Logo', ['width' => 150]) }}
                                <h1 class="text-secondary display-4"><span class="font-weight-bold">Halo</span>Pivot</h1>
                            </div>
                        </div>
                        <div class="col-lg-6 bg-secondary" style="display: flex; align-items: center;">
                            <div class="col-12" style="padding: 0 30px;">
                                <h1 class="text-primary">Log In Here</h1>
                                @include('commons.message')
                                {!! Form::open(['route' => ['authenticate'], 'class' => 'form-group', 'method' => 'post']) !!}
                                <div class="form-group">
                                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'required' => true]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => true]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::submit('Log In', ['class' => 'btn btn-primary btn-block']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

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
    </head>
    <body class="bg-primary">
        <div class="container-fluid" style="height: 100vh;">
            <div class="row" style="height: 100vh">
                <div class="col-12" style="margin-bottom: 30px;">
                    <div class="text-white float-left" style="display: flex; align-items: center; justify-content: center;">
                        {{ Html::image('images/logo-new.jpg', 'Halogen Logo', ['width' => 60]) }}&nbsp;&nbsp;
                        <h4><span class="font-weight-bold">Halo</span>Pivot</h4>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-4" style="padding: 20px;">
                    <div class="bg-white" style="min-height: 450px; border-radius: 7px; padding: 50px;">
                        <h3 style="margin-bottom: 30px;"><span class="font-weight-bold">Change password</span></h3>
                        @include('commons.message')
                        {!! Form::open(['route' => ['update_password', $employee->slug()], 'class' => 'form-group', 'method' => 'post', 'onSubmit' => 'return passwordHash()']) !!}
                        <div class="form-group" style="margin-bottom: 30px;">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => true, 'id' => 'password']) !!}
                        </div>
                        <div class="form-group" style="margin-bottom: 30px;">
                            {!! Form::password('password2', ['class' => 'form-control', 'placeholder' => 'Confirm Password', 'required' => true, 'id' => 'password2']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Update Password', ['class' => 'btn btn-primary btn-block']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-12 justify-content-end text-right text-white">Powered by <a href="https://halogensecurity.com" target="_blank">Strategy Hub | Halogen Security Company</a></div>
            </div>
        </div>
        
        <script type="text/javascript">
            String.prototype.hashCode = function() {
                var hash = "";
                if (this.length == 0)
                    return hash;
                for (i=0; i<this.length; i++) {
                    char = this.charCodeAt(i);
                    hash = ((hash << 5) - hash) + char;
                    hash = hash & hash;           // Convert to 32 bit integer
                }
                return hash;
            }

            function passwordHash() {
                if (document.getElementById('password').value != document.getElementById('password2').value) {
                    alert("Password mismatch!");
                    return false;
                } else {
                    var password = document.getElementById('password').value;
                    //document.getElementById('password').value = password.hashCode();
                    document.getElementById('password').value = password;
                    var password2 = document.getElementById('password2').value;
                    //document.getElementById('password2').value = password2.hashCode();
                    document.getElementById('password2').value = password2;
                    return true;
                }
            }
        </script>
    </body>
</html>

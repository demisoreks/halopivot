<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Induction | {{ config('app.name') }}</title>
        
        {!! Html::style('css/app.css') !!}
        {!! Html::style('css/mdb.min.css') !!}
        
        {!! Html::script('js/jquery-3.3.1.min.js') !!}
        {!! Html::script('js/popper.min.js') !!}
        {!! Html::script('js/app.js') !!}
        {!! Html::script('js/mdb.min.js') !!}
    </head>
    <body style="background-color: #f6f7fb;">
        <div id="pageContent" class="container-fluid" style="height: 100vh;">
            <div class="row bg-primary">
                <div class="col-12">
                    <div class="text-white float-left" style="display: flex; align-items: center; justify-content: center;">
                        {{ Html::image('images/logo-new.jpg', 'Halogen Logo', ['width' => 60]) }}&nbsp;&nbsp;
                        <h4><span class="font-weight-bold">Halo</span>Pivot</h4>
                    </div>
                </div>
            </div>
            <div class="row bg-secondary">
                <div class="col-12" style="height: 10px;">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="page-header" style="border-bottom: 1px solid #999; padding: 30px 0; margin-bottom: 20px; color: #999;">Induction</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card" style="margin-bottom: 20px;">
                                <div class="card-header bg-white">
                                    <strong>INDUCTION VIDEO</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <video class="col-12" controls>
                                            <source src="{{ URL::asset('videos/induction.mp4') }}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card" style="margin-bottom: 20px;">
                                <div class="card-header bg-white">
                                    <strong>SIGN-OFF</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            {!! Form::model(null, ['route' => ['submit_induction', $employee->slug()], 'class' => 'form-group']) !!}
                                                <div class="form-group row">
                                                    {!! Form::label('name', 'Name', ['class' => 'col-md-3 col-form-label']) !!}
                                                    <div class="col-md-9">
                                                        {!! Form::text('name', $value = $name, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => true, 'maxlength' => 100, 'readonly' => true]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        In reference to the induction, this is to attest that I have carefully viewed the introductory videos and all other content(s) contained herewith. I acknowledge that I fully understand the content(s), and that all my questions and enquiries arising therefrom will be directed at the Management and the Human Capital Development.
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        {!! Form::submit('Complete Induction', ['class' => 'btn btn-primary btn-block']) !!}
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 justify-content-end text-right">
                    <div style="border-top: 1px solid #999; margin-top: 20px; padding: 10px 0;">Powered by <a href="https://halogensecurity.com" target="_blank">Strategy Hub | Halogen Security Company</a></div>
                </div>
            </div>
        </div>
        
        <div class="modal fade in" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Welcome!</strong></h5>
                    </div>
                    <div class="modal-body">
                        <p>We are delighted to have you among us.</p>
                        <p>On behalf of the management of Halogen Group, we like to extend our warmest welcome to you, while we look forward to a successful journey with you.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Proceed to Induction</button>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    
    <script>
        $(document).ready(function(){
            $("#modal1").modal('show');
        });
        
        //when modal opens
        $('#modal1').on('shown.bs.modal', function (e) {
          $("#pageContent").css({ opacity: 0.1 });
        })

        //when modal closes
        $('#modal1').on('hidden.bs.modal', function (e) {
          $("#pageContent").css({ opacity: 1 });
        })
    </script>
</html>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Induction | {{ config('app.name') }}</title>
    </head>
    <body>
        {{ Html::image('images/logo-new.jpg', 'Halogen Logo', ['width' => 60]) }}
        <h1>Induction Attestation</h1>
        <p>In reference to the induction, this is to attest that I have carefully viewed the introductory videos and all other content(s) contained herewith. I acknowledge that I fully understand the content(s), and that all my questions and enquiries arising therefrom will be directed at the Management and the Human Capital Development.</p>
        <p>Completed by {{ $name }} on {{ $completion_date }} at {{ $completion_time }}</p>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        Dear <strong>{{ $first_name }}</strong>,<br /><br />
        You have been created as a user on HaloPivot.<br /><br />
        Kindly use the following details to change your password and log in to your account.<br /><br />
        Link: <a href="{{ $link }}">{{ $link }}</a><br />
        Username: {{ $username }}<br />
        Password: {{ $password }}<br /><br />
        Please contact IT Support if you encounter any challenges.<br /><br />
        Regards,<br /><br />
        <strong>Information Technology, Halogen Group</strong><br /><br />
    </body>
</html>

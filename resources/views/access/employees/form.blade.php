<div class="form-group row">
    {!! Form::label('username', 'Username *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('username', $value = null, ['class' => 'form-control', 'placeholder' => 'Username', 'required' => true, 'maxlength' => 100]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('dashboard_view', 'Dashboard View', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('dashboard_view', $value = null, ['class' => 'form-control', 'placeholder' => 'Dashboard View', 'maxlength' => 1000]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('password', 'Password', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('password', '', ['class' => 'form-control', 'placeholder' => 'Password', 'maxlength' => 100, 'id' => 'password']) !!}
    </div>
</div>
<div class="form-group row" hidden="">
    {!! Form::label('password2', 'Password', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::text('password2', '', ['class' => 'form-control', 'placeholder' => 'Password', 'maxlength' => 100, 'id' => 'password2']) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('change_password', 'Change Password *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('change_password', [0 => 'No', 1 => 'Yes'], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary', 'onClick' => 'return passwordHash()']) !!}
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
        var password = document.getElementById('password').value;
        document.getElementById('password2').value = password;
        //document.getElementById('password').value = password.hashCode();
        document.getElementById('password').value = password;
    }
</script>
<div class="form-group row">
    {!! Form::label('privileged_link_id', 'Privileged Link *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('privileged_link_id', App\AccPrivilegedLink::where('active', true)->orderBy('title')->pluck('title', 'id'), $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    {!! Form::label('role_id', 'Role *', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-4">
        {!! Form::select('role_id', [], $value = null, ['class' => 'form-control', 'placeholder' => '- Select Option -', 'required' => true]) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-md-10 offset-md-2">
        {!! Form::submit($submit_text, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#privileged_link_id").change(function() {
            document.getElementById('role_id').length = 1;
            var privileged_link_id = $("#privileged_link_id").val();
            var myString = "";
            
            var ajaxRequest = null;
            
            var browser = navigator.appName;
            if (browser == "Microsoft Internet Explorer") {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } else {
                ajaxRequest = new XMLHttpRequest();
            }
            
            ajaxRequest.onreadystatechange = function() {
                if (ajaxRequest.readyState == 4) {
                    var json_object = JSON.parse(ajaxRequest.responseText);
                    for (var key in json_object) {
                        if (json_object.hasOwnProperty(key)) {
                            $("#role_id").append("<option value="+json_object[key].id+">"+json_object[key].title+"</option>");
                        }
                    }
                }
            }
            
            ajaxRequest.open("GET", "../../../../access/privileged_links/"+privileged_link_id+"/get_roles", true);
            ajaxRequest.send(null);
        });
    });
</script>
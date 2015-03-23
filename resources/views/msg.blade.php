@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

                    <div class="panel-body" id="msgs">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <input type="text" id="msgbox" class="col-md-11"/>
                <button id="sendmsg" class="btn btn-primary col-md-1">Send</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // When send msg, post to controller
        $('#sendmsg').click(function(){
            $.ajax({
                type: "POST",
                url : "msg",
                data: {msg: $('#msgbox').val()},
                headers : {'X-XSRF-TOKEN': $.cookie('XSRF-TOKEN')}
            });
        });
    </script>
@endsection

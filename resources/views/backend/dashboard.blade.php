@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Hello {{Auth::guard('admin')->user()->name}}
                    You are logged in!
                    
                    
                    {{ Auth()->guard('admin')->user()->email  }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

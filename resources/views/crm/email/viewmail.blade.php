@extends('crm.layouts.default')

@section('content')


<div class="row">

    @if(Session::has('success'))
    <div class="alert-box success">
        <h2 class="text-center text-success">{{ Session::get('success') }}</h2>
    </div>  
    @endif
    @if(Session::has('errors'))
    <div class="alert-box success">
        <h2 class="text-center text-danger">{{ Session::get('errors') }}</h2>
    </div>  
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <p><a href="{{route('inbox')}}" class="btn btn-primary btn-sm pull-right">Bandeja de entrada</a></p>
        </div>
        <form class="form-group">
            <label>Mensaje</label>
            <textarea class="form-control" disabled rows="25" cols="50">{{$viewemail->textPlain}}</textarea>
        </form>

    </div>

</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {

    });
</script>
@endsection
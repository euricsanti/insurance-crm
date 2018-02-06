@extends('layouts.app')
@section('content')
<div class="container ">
    
    <div class="content">
        <div class="title">Su usuario no tiene permisos a esta página</div>
        <div class='row'><a href='{{url("/dashboard")}}' class='btn btn-default'>Regresar</a></div>
    </div>
</div>
@endsection
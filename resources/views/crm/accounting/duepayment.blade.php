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
    <div class="col-md-12 col-sm-12 col-xs-12">

        <p  class="col-md-6"><a href="{{url('/home-pos')}}" class="btn btn-primary">Regresar</a></p>

        @role(array('super_user','owner','cashier'))
        <p  class="col-md-6"><a href="{{route('addduepayment')}}" class="btn btn-primary pull-right">Agregar Pendiente</a></p>
        @endrole
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table  class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Pendiente</th>
                    <th>Creador</th>
                    @role(array('super_user','owner', 'sells'))
                    <th>Aplicar</th>
                    @endrole
                    @role(array('super_user','owner', 'sells'))
                    <th>Aplicar</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @forelse($duepayments as $duepayment)
                <tr>
                    <td> {{ $duepayment->title }} </td>
                    <td> {{ $duepayment->duedate }} </td>
                    <td> {{ $duepayment->user_name }} </td>
                    @role(array('super_user','owner', 'sells'))
                    <td><a href="{{route('editduepayment', ['id' => $duepayment->id])}}" class="btn btn-sm btn-info">Editar</a></td>
                    @endrole
                    @role(array('super_user','owner', 'sells'))
                    <td>
                        <form method="POST" action="{{ route('deleteduepayment')}}">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="{{$duepayment->id}}">
                            <input type="hidden" name="user_id" value="{{$duepayment->user_id}}">
                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                        </form>
                    </td>
                    @endrole
                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se encontró ningún pago</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $duepayments->render() }} </div>
    </div>

</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection

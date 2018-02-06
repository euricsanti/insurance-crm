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
        @role(array('super_user','sells'))
        <p  class="col-md-6"><a href="{{route('addpolicy')}}" class="btn btn-primary">Agregar Poliza</a></p>
        @endrole
        @role(array('super_user','sells'))
        <p  class="col-md-6"><a href="{{route('adddependant')}}" class="btn btn-primary pull-right">Agregar dependiente</a></p>
        @endrole
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table  class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Numero de poliza</th>
                    <th>Fecha final</th>
                    <th>Tipo de pago</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse($dependants as $dependant)
                <tr>
                    <td> {{ $dependant->name }} </td>
                    <td> {{ $dependant->surname }} </td>
                    <td> {{ $dependant->policy_no }} </td>
                    <td> {{ $dependant->policy_end_date }} </td>
                    <td> {{ $dependant->policy_payment_type }} </td>
                    <td><a href="{{route('viewuser',['id' => $dependant->id])}}" class="btn btn-sm btn-info">Editar</a></td>

                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado registros</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $dependants->render() }} </div>
    </div>

</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
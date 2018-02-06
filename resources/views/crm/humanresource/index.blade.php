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
        <table  class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>ID de Póliza</th>
                    <th>Fecha fin de Contrato</th>
                    <th>Tipo de pago</th>
                    <td class="text-center">Acción</td>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td> {{ $user->name }} </td>
                    <td> {{ $user->surname }} </td>
                    <td> {{ $user->policy_no }} </td>
                    <td> {{ $user->policy_end_date }} </td>
                    <td> {{ $user->policy_payment_type }} </td>
                    <td>
                        <a href="{{route('rating',['id' => $user->id])}}" class="btn btn-sm btn-info">Valorar</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado registros</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $users->render() }} </div>
    </div>

</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
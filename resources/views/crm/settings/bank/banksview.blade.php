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
        <p  class="col-md-12"><a href="{{route('addbank')}}" class="btn btn-primary pull-right">Agregar Banco</a></p>
        @endrole
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table  class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nombre del banco</th>
                    <th>Número de cuenta bancaria</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                <tr>
                    <td> {{ $bank->bank_name }} </td>
                    <td> {{ $bank->bk_account_number }} </td>
                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado registros</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $banks->render() }} </div>
    </div>

</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
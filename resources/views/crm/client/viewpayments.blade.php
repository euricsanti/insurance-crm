@extends('crm.layouts.default')

@section('content')


<div class="row">

    @if(Session::has('success'))
    <div class="alert-box success">
        <h2 class="text-center text-success">{{ Session::get('success') }}</h2>
    </div>  
    @endif
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('listuser')}}" class="btn btn-primary btn-sm">Back</a></p>
    </div>
    <table id="listpayment" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID Poliza</th>
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Total de Pagos</th>
                <th>Tipo de pagos</th>
                <th>Fecha de pago</th>
                <th>Actualizar fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($viewpayments as $payment)
            <tr>
                <td>{{$payment->policy_no}}</td>
                <td>{{$payment->pos_income}}</td>
                <td>{{$payment->pos_outcome}}</td>
                <td>{{$payment->total_payment_amount}}</td>
                <td>{{$payment->pos_type_of_payment}}</td>
                <td>{{$payment->pos_date}}</td>
                <td>{{$payment->updated_at}}</td>

            </tr>
            @empty
            <tr>
                <td class="text-warning"><b>No se han encontrado registros</b></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination"> {{ $viewpayments->render() }} </div>
</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
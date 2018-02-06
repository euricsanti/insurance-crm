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
        <p  class="col-md-6"><a href="{{route('homeaccounting')}}" class="btn btn-primary">Back</a></p>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12" id="print_div_movement">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Tipo de pago: </label>
                <span>{{$movement->pos_type_of_payment}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Cantidad: </label>
                <span>{{$movement->pos_amount}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Fecha: </label>
                <span>{{$movement->pos_date}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">ID Póliza: </label>
                <span>{{$movement->policy_no}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Aseguradora: </label>
                <span>{{$movement->insurance_company}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Pagos totales: </label>
                <span>{{$movement->total_payment_amount}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Tipos de pagos: </label>
                <span>{{$movement->policy_payment_type}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Nombre: </label>
                <span>{{$movement->name }} {{$movement->surname}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">No de Afiliado: </label>
                <span>{{$movement->affiliate_no}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">NSS: </label>
                <span>{{$movement->nss}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Fecha de registro: </label>
                <span>{{$movement->registry_date}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Fecha de Cumplimientto: </label>
                <span>{{$movement->end_contract_date}}</span>
            </div>
        </div>
        <div class="row">

            <div class="form-group col-md-4">
                <label for="name">Tipo de plan: </label>
                <span>{{$movement->plan_type}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Creado por: </label>
                <span>{{$movement->username}}</span>
            </div>
        </div>

    </div>
    <input type="button" class="btn btn-primary btn-sm" id="printMe_mov" value="Print">
</div>

@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery('#printMe_mov').click(function () {
            jQuery('#print_div_movement').printThis();
        });
    })
</script>
@endsection
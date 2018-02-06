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
        <p  class="col-md-6"><a href="{{route('listclient')}}" class="btn btn-primary">Regresar</a></p>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12" id="print_div">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Nombre: </label>
                <span>{{$viewclient->name}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Apellido: </label>
                <span>{{$viewclient->surname}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Número de Afiliado: </label>
                <span>{{$viewclient->affiliate_no}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">NSS: </label>
                <span>{{$viewclient->nss}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Fecha de registro: </label>
                <span>{{$viewclient->registry_date}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Fecha de finalización: </label>
                <span>{{$viewclient->end_contract_date}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Tipo de plan: </label>
                <span>{{$viewclient->plan_type}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Forma de Pago: </label>
                <span>{{$viewclient->payment_type}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Número de Poliza: </label>
                <span>{{$viewclient->policy_no}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Tipo de Poliza: </label>
                <span>{{$viewclient->type_of_policy}}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Aseguradora: </label>
                <span>{{$viewclient->insurance_company}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Pago total de Poliza: </label>
                <span>{{$viewclient->total_payment_amount}}</span>
            </div>
        </div>
        <div class="row">

            <div class="form-group col-md-4">
                <label for="name">Forma de Pago: </label>
                <span>{{$viewclient->policy_payment_type}}</span>
            </div>
            <div class="form-group col-md-4">
                <label for="name">Creado por: </label>
                <span>{{$user->name}}</span>
            </div>
        </div>

    </div>
    <input type="button" class="btn btn-primary btn-sm" id="printMe" value="Print">
</div>

@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery('#printMe').click(function () {
            jQuery('#print_div').printThis();
        });
    })
</script>
@endsection
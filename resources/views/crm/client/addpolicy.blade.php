@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user'', 'sells')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('homeclient')}}" class="btn btn-primary">Retroceder</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('addpolicy')}}" id="add_policy">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="type_of_policy">Tipo de Poliza</label>
                <input type="text" class="form-control" name="type_of_policy" value="{{old('type_of_policy')}}">
                @if ($errors->has('type_of_policy'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('type_of_policy') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="policy_no">Número de Poliza</label>
                <input type="text" class="form-control" name="policy_no" value="{{old('policy_no')}}">
                @if ($errors->has('policy_no'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('policy_no') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="insurance_company">Aseguradora</label>
                <input type="text" class="form-control" name="insurance_company" value="{{old('insurance_company')}}">
                @if ($errors->has('insurance_company'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('insurance_company') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="type_of_policy">Pago total de Póliza</label>
                <input type="text" class="form-control" name="total_payment_amount" value="{{old('total_payment_amount')}}">
                @if ($errors->has('total_payment_amount'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('total_payment_amount') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="policy_payment_type">Rango de Pago</label>
                <select class="form-control" name="policy_payment_type">
                    <option value="Mensual">Mensual</option>
                    <option value="Trimestral">Trimestral</option>
                    <option value="Semestral">Semestral</option>
                    <option value="Anual">Anual</option>
                </select>
                @if ($errors->has('policy_payment_type'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('policy_payment_type') }}</strong>
                </p>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
    @endrole
</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery('input[name="type_of_policy"]').maxlength({max: 50, showFeedback: false});
        jQuery('input[name="policy_no"]').maxlength({max: 50, showFeedback: false});
        jQuery('input[name="insurance_company"]').maxlength({max: 50, showFeedback: false});
        jQuery('input[name="total_payment_amount"]').maxlength({max: 10, showFeedback: false});
        jQuery('input[name="total_payment_amount"]').mask("###0.00", {reverse: true});
    });
</script>
@endsection

@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user', 'sells')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('homeclient')}}" class="btn btn-primary">Retroceder</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('adddependant')}}" id="add_dependant" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="form-group col-md-6">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    @if ($errors->has('name'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                    </p>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="surname">Apellido</label>
                    <input type="text" class="form-control" name="surname" value="{{old('surname')}}">
                    @if ($errors->has('surname'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('surname') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="form-group col-md-6">
                    <label for="affiliate_no">Número de Afiliado</label>
                    <input type="text" class="form-control" name="affiliate_no" value="{{old('affiliate_no')}}">
                    @if ($errors->has('affiliate_no'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('affiliate_no') }}</strong>
                    </p>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="surname">NSS</label>
                    <input type="text" class="form-control" name="nss" value="{{old('nss')}}">
                    @if ($errors->has('nss'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('nss') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
            <div>

                <div class="form-group col-md-6">
                    <div class="input-group" id="registerdate">
                        <label>Fecha de registro</label>
                        <input type="text" class="form-control" name="registry_date" value="{{old('registry_date')}}">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar client-register-date-span"></span>
                        </div>
                    </div>
                    @if ($errors->has('registry_date'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('registry_date') }}</strong>
                    </p>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <div class="input-group" id="enddate">
                        <label>Fecha de finalización</label>
                        <input type="text" class="form-control" name="end_contract_date" value="{{old('end_contract_date')}}">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar client-end-date-span"></span>
                        </div>
                    </div>
                    @if ($errors->has('end_contract_date'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('end_contract_date') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="form-group col-md-6">
                    <label for="plan_type">Tipo de plan</label>
                    <input type="text" class="form-control" name="plan_type" value="{{old('plan_type')}}">
                    @if ($errors->has('plan_type'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('plan_type') }}</strong>
                    </p>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="payment_type">Forma de Pago</label>
                    <input type="text" class="form-control" name="payment_type" value="{{old('payment_type')}}">
                    @if ($errors->has('payment_type'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('payment_type') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="policy_id">Numero de poliza</label>
                    <select class="form-control" name="policy_id" id="policy_id">
                        <option value="">Please select</option>
                        @forelse($policies as $policy)
                        <option value="{{$policy->id}}">{{$policy->policy_no}}</option>
                        @empty
                        <option value="">Poliza no encontrada</option>
                        @endforelse
                    </select>
                    @if ($errors->has('policy_id'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('policy_id') }}</strong>
                    </p>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label class="btn btn-default btn-file btn-sm ">
                        Cargar archivo <input type="file" name="file_attachment" class="form-control" value="{{old('file_attachment')}}">
                    </label>
                    @if ($errors->has('file_attachment'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('file_attachment') }}</strong>
                    </p>
                    @endif
                </div>

            </div>
            <div class="row" >
                <div class="form-group col-md-6" id="policy_div" style="display:none">
                    <label for="plan_type">Cantidad</label>
                    <input type="text" class="form-control" name="policy_amount" value="">
                </div>
                <div class="form-group col-md-6">
                    <label for="relation">Relación</label>
                    <select class="form-control" name="relation" id="relation">
                        <option value="">Por favor seleccion</option>
                        <option value="Titular">Titular</option>
                        <option value="Familiar">Familiar</option>
                        <option value="Son">Hijo</option>
                        <option value="Mother">Madre</option>
                        <option value="Spouse">Conjugue</option>

                    </select>
                    @if ($errors->has('relation'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('relation') }}</strong>
                    </p>
                    @endif
                </div>
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
        jQuery('input[name="name"]').maxlength({max: 30, showFeedback: false});
        jQuery('input[name="surname"]').maxlength({max: 25, showFeedback: false});
        jQuery('input[name="affiliate_no"]').maxlength({max: 15, showFeedback: false});
        jQuery('input[name="nss"]').maxlength({max: 15, showFeedback: false});
        jQuery('input[name="plan_type"]').maxlength({max: 20, showFeedback: false});
        jQuery('input[name="payment_type"]').maxlength({max: 20, showFeedback: false});
        jQuery('input[name="policy_amount"]').maxlength({max: 8, showFeedback: false});
        jQuery('input[name="policy_amount"]').mask("###0.00", {reverse: true});
        jQuery('input[name="registry_date"]').mask('0000-00-00');
        jQuery('input[name="end_contract_date"]').mask('0000-00-00');
        jQuery('.client-register-date-span').on('click', function () {
            jQuery('#registerdate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        jQuery('.client-end-date-span').on('click', function () {
            jQuery('#enddate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        jQuery(document).on('change', '#policy_id', function () {
            var value = jQuery(this).val();
            jQuery.ajax({
                type: 'POST',
                url: '{{ URL::to("/policyamount") }}',
                data: {policyid: value},
                headers: {
                    'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        jQuery('#policy_div').css('display', 'block');
                        jQuery('#policy_div input[name="policy_amount"]').val(data.data);
                    } else if (data.success == false) {
                        jQuery('#policy_div').css('display', 'none');
                    }
                },
                timeout: 10000,
                error: function (data) {

                }
            });
        });
    });
</script>
@endsection

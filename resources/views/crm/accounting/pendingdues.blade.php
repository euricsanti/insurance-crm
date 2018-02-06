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
                    <th>Número de Póliza</th>
                    <th>Número de Afialiado</th>
                    <th>Proximo Pago</th>
                    <th>Nombre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingdues as $pendingdue)
                <tr>
                    <td> {{ $pendingdue->policy_no }} </td>
                    <td> {{ $pendingdue->affiliate_no }} </td>
                    <td> {{ $pendingdue->end_contract_date }} </td>
                    <td> {{ $pendingdue->name }} {{ $pendingdue->surname }}</td>
                    <td><input type="button" name="pending_due_outcome"  class="btn btn-sm btn-warning pending_due_outcome" data-policyid="{{ $pendingdue->policy_id}}" data-dependantid="{{ $pendingdue->id}}"  data-policytype="{{$pendingdue->type_of_policy }}" data-policyamount="{{$pendingdue->policy_amount }}"value="Pay Outcome"></td>
                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado pagos</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $pendingdues->render() }} </div>
    </div>

</div>
<div class="hidden-md hidden-sm hidden-xs">
    <form action="{{--route('pendingdueoutcome')--}}" method="POST" id="pending_due_outcome_form" name="pending_due_outcome_form" style="display:none;">
        <input type="hidden" name="outcome_dependant_id" value="">
        <input type="hidden" name="outcome_policy_id" value="">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-md-offset-1 col-md-4">
                <label for="pos_policy_paid_for">Poliza</label>
                <span class="outcome_policy_paid_for"></span>
            </div>
        </div>   

        <div class="row">
            <div class="form-group col-md-offset-1 col-md-4">
                <label for="outcome_refrence">Referencia</label>
                <input type="text" class="form-control" name="outcome_refrence">
            </div>
            <div class="input-group  col-md-4" id="outcome_date">
                <label>Fecha</label>
                <input type="text" class="form-control" name="outcome_date" value="">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar outcome-date-span"></span>
                </div>
            </div>

            <div class="form-group col-md-offset-1 col-md-4">
                <label for="outcome_input_amount">Cantidad a pagar</label>
                <input type="number" class="form-control" name="outcome_input_amount" readonly="readonly">
            </div>

            <div class="form-group col-md-4 bank-info ">
                <label for="outcome_bank_info">Bancos</label>

                <select class="form-control" name="outcome_bank_info">
                    @forelse($banks as $bank)
                    <option value="{{$bank->bank_name}}">{{$bank->bank_name}}</option>
                    @empty
                    <option value="">No se han encontrado bancos</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="row">
            <input type="button" class="btn btn-primary btn-sm outcome_add_payment col-md-offset-1" value="Add Outcome">
        </div>
    </form>
</div>

@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery('input[name="outcome_refrence"]').maxlength({max: 14, showFeedback: false});
        jQuery('input[name="outcome_date"]').mask("0000-00-00");
        jQuery('input[name="outcome_input_amount"]').mask("###0.00", {reverse: true});
        jQuery('input[name="outcome_input_amount"]').maxlength({max: 10, showFeedback: false});
        jQuery(document).on('click', '.pending_due_outcome', function () {
            var dependant_id = jQuery(this).data('dependantid');
            var policyid = jQuery(this).data('policyid');
            var policytype = jQuery(this).data('policytype');
            var policyamount = jQuery(this).data('policyamount');
            jQuery('#pending_due_outcome_form input[name="outcome_dependant_id"]').val(dependant_id);
            jQuery('#pending_due_outcome_form input[name="outcome_policy_id"]').val(policyid);
            jQuery('#pending_due_outcome_form .outcome_policy_paid_for').html(policytype);
            jQuery('#pending_due_outcome_form input[name="outcome_input_amount"]').val(policyamount);
            jQuery('#pending_due_outcome_form').bPopup({
                modalClose: true,
                opacity: 0.6,
                positionStyle: 'fixed', //'fixed' or 'absolute'
                position: [150, 150]
            });
        });
        jQuery('.outcome-date-span').on('click', function () {
            jQuery('#outcome_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        jQuery(document).on('click', '.outcome_add_payment', function () {
            var form = document.forms.namedItem('pending_due_outcome_form');
            var formdata = new FormData(form);
            console.log(formdata);
            jQuery.ajax({
                async: true,
                type: 'POST',
                url: '{{ URL::to("/pending-dueoutcome") }}',
                data: formdata,
                headers: {
                    'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    jQuery('#pos_total_balance').val(' ');
                    if (data.success === true) {
                        window.location.href = data.redirect_url;
                    } else if (data.success === false) {
                        window.location.href = data.redirect_url;
                    }
                },
                timeout: 10000,
                error: function (data) {

                }
            })
        });
    });
</script>
@endsection
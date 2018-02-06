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
	 <div class="row">
	 @if($manage_pos)
		 @if($manage_pos->status == 'close')
		<div class="col-md-6">
			<form action="{{route('openpos')}}" method="POST" id="openpos_form" name="openpos_form">
				{{ csrf_field() }}
				<input type="hidden" value="" name="open_pos_id" >
				<input type="submit" name="open_pos" value="Open POS" class="btn btn-success btn-sm">
			</form>
		</div>
		@endif
	@else
		<div class="col-md-6">
			<form action="{{route('openpos')}}" method="POST" id="openpos_form" name="openpos_form">
				{{ csrf_field() }}
				<input type="hidden" value="" name="open_pos_id" >
				<input type="submit" name="open_pos" value="Open POS" class="btn btn-success btn-sm">
			</form>
		</div>
	@endif
	@if($manage_pos)
		@if($manage_pos->status == 'open')
		<div  class="pull-right">
			<form action="{{route('closepos')}}" method="POST" id="closepos_form" name="closepos_form">
				{{ csrf_field() }}
				<input type="hidden" value="<?php echo ($manage_pos->open_pos_id)? $manage_pos->open_pos_id:''; ?>" name="open_pos_id" id="open_pos_id">
				<input type="submit" name="close_pos" value="Close POS" class="btn btn-warning btn-sm">
			</form>
		</div>
		@endif
	@endif
	</div>
	</div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Número de Poliza: </label>
                <input type="text" name="pos_policy_no" id="pos_policy_no">
            </div>
            <div class="form-group col-md-4">
                <label for="name">Número de Afiliado: </label>
                <input type="text" name="pos_affiliate_no" id="pos_affiliate_no">
            </div>
            <div class="form-group col-md-4">

                <div class="col-md-6">
                    <!--a href="{{--route('duepayment')--}}" class="btn btn-primary btn-sm" id="pos_duepayment" >Outcome</a-->
                </div>

            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Nombre: </label>
                <input type="text" name="pos_name" id="pos_name">
            </div>
            <div class="form-group col-md-4">
                <label for="name">Apellido: </label>
                <input type="text" name="pos_surname" id="pos_surname">
            </div>
            <!--div class="form-group col-md-4">
                <input type="button" class="btn btn-primary btn-sm" id="pos_today_total" value="Today Total">
            </div-->
        </div>

        <div class="row">
            <!--div class="form-group col-md-4 pos-total-div">
                <label for="name">Total Balance: </label>
                <input type="text" name="pos_total_balance" id="pos_total_balance" value="">
            </div-->
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table  class="table table-striped table-hover" id="posresult_table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID Póliza</th>
                    <th>Numero de Afiliado</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Aseguradora</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="hidden-md hidden-sm hidden-xs">
        <form action="{{--route('pospay')--}}" method="POST" id="pos_pay_form" name="pos_pay_form" style="display:none;">
            <input type="hidden" name="pos_dependant_id" value="">
            <input type="hidden" name="pos_policy_id" value="">
            {{ csrf_field() }}
            <div class="row">
                <div class="form-group col-md-offset-1 col-md-4">
                    <label for="pos_policy_paid_for">Poliza</label>
                    <span class="pos_policy_paid_for"></span>
                </div>
            </div>   
            <div class="row">
                <div class="form-group col-md-offset-1 col-md-4">
                    <label for="pos_type_of_payment">Tipo de pago</label>
                    <select class="form-control" name="pos_type_of_payment" id="pos_type_of_payment">
                        <option value="">Por favor seleccione</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta-de-Crédito">Pago directo</option>
                        <option value="Depósito-Bancario">Depósito Bancario</option>

                    </select>
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-offset-1 col-md-4">
                    <label for="pos_amount">Referencia</label>
                    <input type="text" class="form-control" name="pos_refrence">
                </div>
                <div class="input-group  col-md-4" id="pos_date">
                    <label>Fecha</label>
                    <input type="text" class="form-control" name="pos_date" value="">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar pos-date-span"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-offset-1 col-md-4">
                    <label for="pos_input_amount">Total a pagar</label>
                    <input type="number" class="form-control" name="pos_input_amount">
                </div>
                <div class="form-group  col-md-4">
                    <label for="pos_amount_due">Pendiente por pagar</label>
                    <input type="number" class="form-control" name="pos_amount_due">
                </div>
            </div>
            <div class="row" id="pos_type_pay_div">

            </div>
            <div class="row">
                <div class="form-group col-md-4 bank-info col-md-offset-1 " style="display:none">
                    <label for="pos_bank_info">Cantidad</label>

                    <select class="form-control" name="pos_bank_info" id="pos_bank_info">
                        @forelse($banks as $bank)
                        <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                        @empty
                        <option value="">No se han encontrado bancos</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row" id="pos_type_pay_div_2" style="display:none">
				<div class="form-group  col-md-4  col-md-offset-1">
					<input type="text" placeholder="Bank Account" name="bank" class="bank form-control"  value="" >
				</div>	
			</div>

            <div class="row">
                <input type="button" class="btn btn-primary btn-sm pos_add_payment col-md-offset-1 " value="Add Payment">
            </div>
        </form>
    </div>
</div>


@endsection

@section('javascripts')

<script>
    jQuery(document).ready(function () {
        jQuery('input[name="pos_refrence"]').maxlength({max: 14, showFeedback: false});
        jQuery('input[name="pos_date"]').mask("0000-00-00");
        jQuery('input[name="pos_input_amount"]').mask("###0.00", {reverse: true});
        jQuery('input[name="pos_input_amount"]').maxlength({max: 10, showFeedback: false});
        jQuery('input[name="pos_amount_due"]').maxlength({max: 10, showFeedback: false});
        //jQuery('input[name="pos_amount_due"]').mask("###0.00", {reverse: true});
        jQuery('#pos_policy_no').on('input', function () {
            var pos_policy_no = jQuery(this).val();
            var pos_affiliate_no = jQuery("input[name='pos_affiliate_no']").val();
            var pos_name = jQuery("input[name='pos_name']").val();
            var pos_surname = jQuery("input[name='pos_surname']").val();
            if (pos_policy_no.length > 3) {
                jQuery('body').LoadingOverlay("show", {
                    fade: true,
                    color: "rgba(255, 255, 255, 0.5)"
                });
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('searchpos')}}",
                    data: {
                        policy_no: pos_policy_no,
                        affiliate_no: pos_affiliate_no,
                        name: pos_name,
                        surname: pos_surname,
                    },
                    headers: {
                        'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    success: function (data) {
                        jQuery('body').LoadingOverlay("hide");
                        jQuery('#posresult_table tbody').html(' ');
                        if (data.success == true) {
                            jQuery.each(data.res, function (index, value) {
                                jQuery('<tr><td><input type="checkbox" class="pos_check" value="1"></td><td>' + value.policy_no + '</td><td>' + value.affiliate_no + '</td><td>' + value.name + '</td><td>' + value.surname + '</td><td>' + value.insurance_company + '</td><td><input type="button" class="pos-pay btn btn-info btn-sm" data-id="' + value.id + '" data-policyid="' + value.policy_id + '" data-policytype="' + value.type_of_policy + '" data-policyamount="' + value.policy_amount + '" data-policyamountleft="' + value.amount_left + '" value="Pay" disabled="disabled"></td></tr>').appendTo('#posresult_table tbody');
                            });
                        } else if (data.success == false) {
                            jQuery('<tr><td></td><td>' + data.res + '</td></tr>').appendTo('#posresult_table tbody');
                        }

                    },
                    timeout: 10000,
                    error: function (data) {

                    }
                })
            }
        })
        jQuery('#pos_affiliate_no').on('input', function () {
            var pos_policy_no = jQuery("input[name='pos_policy_no']").val();
            var pos_affiliate_no = jQuery(this).val();
            var pos_name = jQuery("input[name='pos_name']").val();
            var pos_surname = jQuery("input[name='pos_surname']").val();
            if (pos_affiliate_no.length > 3) {
                jQuery('body').LoadingOverlay("show", {
                    fade: true,
                    color: "rgba(255, 255, 255, 0.5)"
                });
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('searchpos')}}",
                    data: {
                        policy_no: pos_policy_no,
                        affiliate_no: pos_affiliate_no,
                        name: pos_name,
                        surname: pos_surname,
                    },
                    headers: {
                        'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (data) {
                        jQuery('body').LoadingOverlay("hide");
                        jQuery('#posresult_table tbody').html(' ');
                        if (data.success == true) {
                            jQuery.each(data.res, function (index, value) {
                                jQuery('<tr><td><input type="checkbox" class="pos_check" value="1"></td><td>' + value.policy_no + '</td><td>' + value.affiliate_no + '</td><td>' + value.name + '</td><td>' + value.surname + '</td><td>' + value.insurance_company + '</td><td><input type="button" class="pos-pay btn btn-info btn-sm" data-id="' + value.id + '" data-policyid="' + value.policy_id + '" data-policytype="' + value.type_of_policy + '" data-policyamount="' + value.policy_amount + '" data-policyamountleft="' + value.amount_left + '" value="Pay" disabled="disabled"></td></tr>').appendTo('#posresult_table tbody');
                            });
                        } else if (data.success == false) {
                            jQuery('<tr><td></td><td>' + data.res + '</td></tr>').appendTo('#posresult_table tbody');
                        }

                    },
                    timeout: 10000,
                    error: function (data) {
                    }})
            }
        })
        jQuery('#pos_name').on('input', function () {
            var pos_policy_no = jQuery("input[name='pos_policy_no']").val();
            var pos_affiliate_no = jQuery("input[name='pos_affiliate_no']").val();
            var pos_name = jQuery(this).val();
            var pos_surname = jQuery("input[name='pos_surname']").val();
            if (pos_name.length > 3) {
                jQuery('body').LoadingOverlay("show", {
                    fade: true,
                    color: "rgba(255, 255, 255, 0.5)"
                });
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('searchpos')}}",
                    data: {
                        policy_no: pos_policy_no,
                        affiliate_no: pos_affiliate_no,
                        name: pos_name,
                        surname: pos_surname,
                    },
                    headers: {
                        'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (data) {
                        jQuery('body').LoadingOverlay("hide");
                        jQuery('#posresult_table tbody').html(' ');
                        if (data.success == true) {
                            jQuery.each(data.res, function (index, value) {
                                jQuery('<tr><td><input type="checkbox" class="pos_check" value="1"></td><td>' + value.policy_no + '</td><td>' + value.affiliate_no + '</td><td>' + value.name + '</td><td>' + value.surname + '</td><td>' + value.insurance_company + '</td><td><input type="button" class="pos-pay btn btn-info btn-sm" data-id="' + value.id + '" data-policyid="' + value.policy_id + '" data-policytype="' + value.type_of_policy + '" data-policyamount="' + value.policy_amount + '" data-policyamountleft="' + value.amount_left + '" value="Pay" disabled="disabled"></td></tr>').appendTo('#posresult_table tbody');
                            });
                        } else if (data.success == false) {
                            jQuery('<tr><td></td><td>' + data.res + '</td></tr>').appendTo('#posresult_table tbody');
                        }

                    },
                    timeout: 10000,
                    error: function (data) {

                    }
                })
            }
        })
        jQuery('#pos_surname').on('input', function () {
            var pos_policy_no = jQuery("input[name='pos_policy_no']").val();
            var pos_affiliate_no = jQuery("input[name='pos_affiliate_no']").val();
            var pos_name = jQuery("input[name='pos_name']").val();
            var pos_surname = jQuery(this).val();
            if (pos_surname.length > 3) {
                jQuery('body').LoadingOverlay("show", {
                    fade: true,
                    color: "rgba(255, 255, 255, 0.5)"
                });
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('searchpos')}}",
                    data: {
                        policy_no: pos_policy_no,
                        affiliate_no: pos_affiliate_no,
                        name: pos_name,
                        surname: pos_surname,
                    },
                    headers: {
                        'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (data) {
                        jQuery('body').LoadingOverlay("hide");
                        jQuery('#posresult_table tbody').html(' ');
                        if (data.success == true) {
                            jQuery.each(data.res, function (index, value) {
                                jQuery('<tr><td><input type="checkbox" class="pos_check" value="1"></td><td>' + value.policy_no + '</td><td>' + value.affiliate_no + '</td><td>' + value.name + '</td><td>' + value.surname + '</td><td>' + value.insurance_company + '</td><td><input type="button" class="pos-pay btn btn-info btn-sm" data-id="' + value.id + '" data-policyid="' + value.policy_id + '" data-policytype="' + value.type_of_policy + '" data-policyamount="' + value.policy_amount + '" data-policyamountleft="' + value.amount_left + '" value="Pay" disabled="disabled"></td></tr>').appendTo('#posresult_table tbody');
                            });
                        } else if (data.success == false) {
                            jQuery('<tr><td></td><td>' + data.res + '</td></tr>').appendTo('#posresult_table tbody');
                        }

                    },
                    timeout: 10000,
                    error: function (data) {

                    }
                });
            }
        });
        jQuery(document).on('click', '.pos_check', function () {
            if (jQuery(this).prop("checked") == true) {
                jQuery(this).closest("tr").find('.pos-pay').prop("disabled", false);
            } else {
                jQuery(this).closest("tr").find('.pos-pay').prop("disabled", true);
            }
        });
        jQuery(document).on('click', '.pos-pay', function () {
            var dependant_id = jQuery(this).data('id');
            var policyid = jQuery(this).data('policyid');
            var policytype = jQuery(this).data('policytype');
            var policyamount = jQuery(this).data('policyamount');
            var policyamountleft = jQuery(this).data('policyamountleft');
            var amountdue = parseFloat(policyamount) + parseFloat(policyamountleft);
			//alert(amountdue);
            jQuery('#pos_pay_form input[name="pos_dependant_id"]').val(dependant_id);
            jQuery('#pos_pay_form input[name="pos_policy_id"]').val(policyid);
            jQuery('#pos_pay_form input[name="pos_amount_due"]').val(amountdue);
            jQuery('#pos_pay_form .pos_policy_paid_for').html(policytype);
            jQuery('#pos_pay_form').bPopup({
                modalClose: true,
                opacity: 0.6,
                positionStyle: 'fixed', //'fixed' or 'absolute'
                position: [150, 150]
            });
        });
        jQuery(document).on('input', 'input[name="pos_input_amount"]', function () {
            var inputamount = jQuery(this).val();
            if (inputamount.length > 3) {
                var amount_left = jQuery('input[name="pos_amount_due"]').val();
                if (parseFloat(inputamount) <= parseFloat(amount_left)) {
                    jQuery('.pos_add_payment').prop("disabled", false);
                } else {
					//alert('Please pay less amount');
                    //jQuery('.pos_add_payment').prop("disabled", true);
                }
            }

        })
        jQuery(document).on('click', '.pos_add_payment', function (e) {
            var form = document.forms.namedItem('pos_pay_form');
            var formdata = new FormData(form);
			var open_pos_id = jQuery('#open_pos_id').val();
			if(open_pos_id){
				formdata.append('open_pos_id', open_pos_id);
				var amount_paid = jQuery('input[name="pos_input_amount"]').val();
				var amount_left = jQuery('input[name="pos_amount_due"]').val();
				if (parseInt(amount_paid) <= parseInt(amount_left)) {
					jQuery(this).prop("disabled", false);
					jQuery.ajax({
						async: true,
						type: 'POST',
						url: '{{ URL::to("/pos-pay") }}',
						data: formdata,
						processData: false,
						contentType: false,
						headers: {
							'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
						},
						dataType: 'json', success: function (data) {
							if (data.success === true) {
								window.location.href = data.redirect_url;
							} else if (data.success === false) {
								//window.location.href = data.redirect_url;
							}
						},
						timeout: 10000,
						error: function (data) {

						}
					})
				} else {
					jQuery(this).prop("disabled", true);
				}
			}else{
				jQuery('#pos_pay_form').bPopup().close();
				setTimeout(
					  function() {
						swal({
						  title: "Error!",
						  text: "Please open the POS first",
						  type: "error",
						  timer: 3000
						});
					  }, 1000);
				
			}
        });
        jQuery('.pos-date-span').on('click', function () {
            jQuery('#pos_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        jQuery(document).on('change', '#pos_type_of_payment', function () {
			jQuery('#pos_type_pay_div_2').css('display','none');
            var selected = jQuery(this).val();
            jQuery('#pos_type_pay_div').html(' ');
            jQuery('#pos_type_pay_div_1').html(' ');
            if (selected == 'Efectivo') {
                jQuery('.bank-info').css('display', 'none');
                jQuery('<div class="form-group col-md-offset-1 col-md-4 efectivo"><div>').appendTo('#pos_type_pay_div');
                jQuery('<label for="pos_amount">Cantidad</label>').appendTo('.efectivo');
                jQuery('<select class="form-control" name="pos_amount"><option value="DOP">DOP</option> <option value="USD">USD</option> <option value="EUR">EUR</option></select>').appendTo('.efectivo');
            } else if (selected == 'Depósito-Bancario') {
				
				jQuery('<div class="form-group col-md-offset-1 col-md-4 depósito-bancario"><div>').appendTo('#pos_type_pay_div');
				jQuery('.bank-info').css('display', 'block');
				
            } else {
                jQuery('.bank-info').css('display', 'none');
            }
        });
		
		jQuery(document).on('change','#pos_bank_info',function(){
			var bank_id = jQuery(this).val();
				jQuery.ajax({
					 type: 'POST',
					 url: '{{ URL::to("/bk-acc-no") }}',
					 data: {bank_id: bank_id},
					 headers: {
					 'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
					 },
					 dataType: 'json',
					 success: function (data) {
						if (data.success == true) {
							jQuery('#pos_type_pay_div_2').css('display','block');
							jQuery('.bank').val(data.res.bk_account_number);
							//jQuery('.bank').mask("0000000000000000");
						} else if (data.success === false) {
							
						}
					 },
					 timeout: 10000,
					 error: function (data) {
					 
					 }
				});
		});
		
        /*jQuery(document).on('click', '.add-more', function () {
            jQuery('.bank:first').clone().appendTo('.add-more-div');
        });*/
        /*jQuery('#pos_today_total').on('click', function () {
         Date.prototype.todaydate = function () {
         var yyyy = this.getFullYear().toString();
         var mm = (this.getMonth() + 1).toString();
         var dd = this.getDate().toString();
         return yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]); // padding
         };
         var date = new Date();
         jQuery.ajax({
         type: 'POST',
         url: '{{ URL::to("/today-total") }}',
         data: {date: date.todaydate()},
         headers: {
         'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
         },
         dataType: 'json',
         success: function (data) {
         jQuery('#pos_total_balance').val(' ');
         if (data.success === true) {
         jQuery('#pos_total_balance').val();
         } else if (data.success === false) {
         jQuery('#pos_total_error').html(' ');
         jQuery('.pos-total-div').append('<p id="pos_total_error" class="text-danger"></p>');
         jQuery('#pos_total_error').html(data.res);
         }
         },
         timeout: 10000,
         error: function (data) {
         
         }
         })
         });*/
		 
    });
</script>
@endsection   
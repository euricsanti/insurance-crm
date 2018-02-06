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
    <div class="col-md-6">
        <label>Rango de fechas</label>
        <input type="text" name="daterange" value="01-04-2017 - 30-11-2017" class="form-group"/>
    </div>
    <div class="col-md-6">
        <label></label>
        <input type="button" class="form-group btn btn-sm btn-primary pull-right" id="print_movements" value="Total Print"/>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <table  class="table table-striped table-hover" id="movements_tab">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Ingreso Total</th>
                    <th>Egreso Total</th>
                    <th>Open POS id</th>
                    <th>Tipo de pago</th>
                    <th>Acción</th>
                    <th>Seleccionar</th>
                    @role('super_user')
                    <th class='movements_modify'>Modificar</th>
                    @endrole
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>

@endsection

@section('javascripts')

<script>
    jQuery(document).ready(function () {
        jQuery(function () {
            jQuery('input[name="daterange"]').daterangepicker(
                    {
                        locale: {
                            format: 'YYYY-MM-DD'
                        },
                        startDate: '2017-03-01',
                        endDate: '2017-12-01'
                    },
            function (start, end, label) {
                //alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                jQuery('body').LoadingOverlay("show", {
                    fade: true,
                    color: "rgba(255, 255, 255, 0.5)"
                });
                jQuery.ajax({
                    type: 'POST',
                    url: '{{ URL::to("/showposmovements") }}',
                    data: {start: start.format('YYYY-MM-DD'), end: end.format('YYYY-MM-DD')},
                    headers: {
                        'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function (data) {
                        jQuery('#movements_tab tbody').html(' ');
                        jQuery('body').LoadingOverlay("hide");
                        if (data.success == true) {
                            jQuery.each(data.res, function (index, value) {
                                var check = jQuery(".movements_modify");
                                if (jQuery.contains(window.document, check[0])) {
                                    var checked = '<a href="' + data.url + '/editmovement/' + value.id + '" class="btn btn-sm btn-primary">Edit</a>';
                                } else {
                                    var checked = '';
                                }
                                if (value.pos_type_of_payment == "Efectivo") {
                                    var amount = value.pos_amount;
                                } else if (value.pos_type_of_payment == "Tarjeta-de-Crédito") {
                                    var amount = " ";
                                } else if (value.pos_type_of_payment == "Depósito-Bancario") {
                                    var bankarr = JSON.parse(value.posbankinfo);
									if(bankarr){
										//var amount = bankarr.bank_acc.join(', ');
										//var amount = bankarr.bank_name + '-' + amount;
									}
                                    
                                }
                                jQuery('<tr><td>' + value.pos_date + '</td><td>' + ((value.pos_income != null) ? value.pos_income : "") + '</td><td>' + ((value.pos_outcome != null) ? value.pos_outcome : "") + '</td><td>' + ((value.open_pos_id != null) ? value.open_pos_id : "") + '</td><td>' + ((value.pos_type_of_payment != null) ? value.pos_type_of_payment : "") + '</td><td><a href="' + data.url + '/viewmovement/' + value.id + '" class="btn btn-info btn-sm">View</a></td><td><input type="checkbox" value="1" name="movement_selection_' + index + '"></td><td>' + checked + '</td></tr>').appendTo('#movements_tab tbody');
                            });
                        } else if (data.success == false) {
                            jQuery('<tr><td>' + data.res + '</td></tr>').appendTo('#movements_tab tbody');
                        }
                    },
                    timeout: 10000,
                    error: function (data) {

                    }
                });
            });
        });
        jQuery('#print_movements').click(function () {
            jQuery('#movements_tab').printThis();
        });
    });


</script>
@endsection
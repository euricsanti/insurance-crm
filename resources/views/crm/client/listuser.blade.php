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
        <table  id="listuser" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>ID Póliza</th>
                    <th>Fecha final</th>
                    <th>Tipo de pago</th>
                    <td>Accion</td>
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
                        <a href="{{route('viewuser',['id' => $user->id])}}" class="btn btn-sm btn-info">Editar</a>
                        <a href="{{route('viewpayment',['id' => $user->id])}}" class="btn btn-sm btn-info">JVer pago</a>
                        @if($user->status == 1)
                        <input type="button" class="btn btn-warning btn-sm" value="Deactivate dependent" id="deactivate_dependant" data-dependant_id="{{$user->id}}">
                        @endif
                        @if($user->status == 0)
                        <input type="button" class="btn btn-primary btn-sm" value="Activate dependent" id="activate_dependant" data-dependant_id="{{$user->id}}">
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado dependientes</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
       
    </div>

</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
		jQuery('#listuser').DataTable({
            "processing": true,
            "serverSide": false,
            "ordering": true,
            "paging": true,
            "searching": true
        });
        jQuery(document).on('click', '#deactivate_dependant', function () {
            var dependant_id = jQuery(this).data('dependant_id');
            jQuery.ajax({
                type: 'POST',
                url: '{{ URL::to("/deactivateuser") }}',
                data: {
                    dependant_id: dependant_id
                },
                headers: {
                    'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success === true) {
                        window.location.href = data.redirect_url;
                    } else if (data.success === false) {
                        /*jQuery.each(data.message, function (index, value) {
                         jQuery('#singleclass_msg').append('<p>' + value + '</p>');
                         });*/
                    }
                },
                timeout: 10000,
                error: function (data) {

                }
            });
        });
        jQuery(document).on('click', '#activate_dependant', function () {
            var dependant_id = jQuery(this).data('dependant_id');
            jQuery.ajax({
                type: 'POST',
                url: '{{ URL::to("/activateuser") }}',
                data: {
                    dependant_id: dependant_id
                },
                headers: {
                    'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success === true) {
                        window.location.href = data.redirect_url;
                    } else if (data.success === false) {
                        /*jQuery.each(data.message, function (index, value) {
                         jQuery('#singleclass_msg').append('<p>' + value + '</p>');
                         });*/
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
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
    <div>
        <form method="GET" action="{{route('listclient')}}" id="list_policy_form" class="form-inline" style="padding-bottom:5px">
            {{ csrf_field() }}

            <div class="form-group">
                {{ Form::select('list_policy', $policy_type,Request::get('list_policy'),['class' => 'form-control input-sm']) }}
            </div>
            <div class="form-group" style="margin-top: -6px;">
                <button type="submit" class="btn btn-default btn-sm">Búscar póliza</button>
            </div>
        </form>
    </div>

    <table id="listclient" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Número de Poliza</th>
                <th>Tipo de pago</th>
                <th>Tipo de afiliado</th>
                <th>Relacion</th>
                <th>Acción</th>
                <th>Ver Adjuntos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listclients as $client)
            <tr>
                <td>{{$client->name}}</td>
                <td>{{$client->surname}}</td>
                <td>{{$client->policy_no}}</td>
                <td>{{$client->policy_payment_type}}</td>
                <td>{{$client->affiliate_no}}</td>
                <td>{{$client->relation}}</td>
                <td><a href="{{route('viewclient',['id'=> $client->id])}}" class="btn btn-info btn-sm">Ver</a>
                <a href="{{route('viewuser',['id' => $client->id])}}" class="btn btn-sm btn-info">Editar</a></td>
                @if($client->file_attachment)
                <td><input type="button" class="btn btn-sm btn-primary view-attachment" value="Ver adjuntos" data-id="{{$client->id}}"></td>
                @else
                <td></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="view_attachment_div" style="display: none">

    </div>

</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery('#listclient').DataTable({
            "processing": true,
            "serverSide": false,
            "ordering": true,
            "paging": true,
            "searching": true
        });
        jQuery('.view-attachment').on('click', function () {
            var id = jQuery(this).data('id');
            jQuery('body').LoadingOverlay("show", {
                fade: true,
                color: "rgba(255, 255, 255, 0.5)"
            });
            jQuery.ajax({
                type: 'POST',
                url: '{{ URL::to("/showattachment") }}',
                data: {id: id},
                headers: {
                    'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    jQuery('#view_attachment_div').html(' ');
                    jQuery('body').LoadingOverlay("hide");
                    if (data.success == true) {
                        jQuery('<a href="' + data.res + '" download class="btn btn-default btn-sm"><img src="' + data.res + '" height="200" width=200></a>').appendTo('#view_attachment_div');
                        jQuery('<br><input type="button" class="btn btn-primary btn-sm" id="printattachment" value="Print">').appendTo('#view_attachment_div');
                        jQuery('#view_attachment_div').bPopup({
                            modalClose: true,
                            opacity: 0.6,
                            positionStyle: 'fixed'
                        });
                    } else if (data.success == false) {

                    }
                },
                timeout: 10000,
                error: function (data) {

                }
            });
        })
        jQuery(document).on('click', '#printattachment', function () {
            jQuery('#view_attachment_div').printThis();
        });
    });
</script>
@endsection
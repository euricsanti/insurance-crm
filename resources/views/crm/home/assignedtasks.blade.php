@extends('crm.layouts.default')

@section('content')


<div class="row">

    @if(Session::has('success'))
    <div class="alert-box success">
        <h2 class="text-center text-success">{{ Session::get('success') }}</h2>
    </div>
    @endif
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p class="col-md-6"><a href="{{url('/home-daily')}}" class="btn btn-primary">Regresar</a></p>
        @role('super_user','sells', 'collect', 'cashier')
        <p  class="col-md-6"><a href="{{route('addtask')}}" class="btn btn-primary pull-right">Agregar Tareas</a></p>
        @endrole
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12" id="ajax-error">

    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Notas</th>
                    <th>Asignar a: </th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignedtasks as $task)
                <tr>
                    <td> {{ $task->tasknote }} </td>
                    <td> {{ $task->name }} </td>
                    @if($task->status == 0)
                    <td><input type="button" class="btn btn-primary btn-sm mark_task_completed" data-id="{{$task->id}}" value="Mark As Completed"></td>
                    @elseif($task->status == 1)
                    <td><input type="button" disabled="disabled" class="btn btn-success btn-sm" value="Completed"></td>
                    @endif

                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado tareas pendientes</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $assignedtasks->render() }} </div>
    </div>

</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery(document).on('click', '.mark_task_completed', function (e) {
            var assigned_task_id = jQuery(this).data('id');
            jQuery.ajax({
                type: 'POST',
                url: '{{ URL::to("/markcomplete") }}',
                data: {
                    'task_id': assigned_task_id
                },
                dataType: 'JSON',
                headers: {
                    'X-CSRF-Token': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    jQuery('#ajax-error').html('');
                    if (data.success === true) {
                        window.location.href = data.redirect_url;
                    } else if (data.success === false) {
                        jQuery.each(data.message, function (index, value) {
                            jQuery('#ajax-error').append('<p class="text-danger">' + value + '</p>');
                        });
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

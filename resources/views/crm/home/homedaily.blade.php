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
        <p class="col-md-6"><a href="{{route('assignedtasks')}}" class="btn btn-primary">Tareas asignadas</a></p>
        @role('super_user','owner','sells', 'collect', 'cashier')
        <p  class="col-md-6"><a href="{{route('addtask')}}" class="btn btn-primary pull-right">Agregar Tareas</a></p>
        @endrole
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table  class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Notas</th>
                    <th>Asignar tarea</th>
                    @role('super_user','owner')
                    <th>Aplicar</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td> {{ $task->tasknote }} </td>
                    <td><input type="button" class="btn btn-primary btn-sm assign_task" data-id="{{$task->id}}" value="Asignar tarea"></td>
                    @role('super_user','owner')
                    <td>
                        <form method="POST" action="{{ route('deletenote')}}">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="{{$task->id}}">
                            <input type="hidden" name="user_id" value="{{$task->user_id}}">
                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                        </form>
                    </td>
                    @endrole
                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado tareas</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $tasks->render() }} </div>
    </div>
    <div class="hidden-md hidden-sm hidden-xs">
        <form action="{{route('assigntasks')}}" method="POST" id="assign_task_form" name="assign_task_form" style="display:none">
            <input type="hidden" name="task_id" value="">
            <div class="form-group">
                <label for="sel1">Asignar a: </label>
                <select class="form-control" name="assigned_user_id">
                    @forelse($users as $key => $user)
                    <option value="{{$key}}">{{$user}}</option>
                    @empty
                    <option value="">No hay registros</option>
                    @endforelse

                </select>
            </div>
            <input type="button" class="btn btn-primary btn-sm user_assign_task" value="Assign">
        </form>
    </div>
</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery(document).on('click', '.assign_task', function () {
            var task_id = jQuery(this).data('id');
            jQuery('input[name="task_id"]').val(task_id);
            jQuery('#assign_task_form').bPopup({
                modalClose: true,
                opacity: 0.6,
                positionStyle: 'fixed' //'fixed' or 'absolute'
            });
        });

        jQuery(document).on('click', '.user_assign_task', function (e) {
            var form = document.forms.namedItem('assign_task_form');
            var formdata = new FormData(form);
            jQuery.ajax({
                async: true,
                type: 'POST',
                url: '{{ URL::to("/assigntasks") }}',
                data: formdata,
                processData: false,
                contentType: false,
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
            })

        });
    });
</script>
@endsection

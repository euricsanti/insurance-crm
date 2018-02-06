@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('homeaccounting')}}" class="btn btn-primary">Regresar</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('saveeditmovement', ['id' => $movement->id])}}" id="edit_movement">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            <div class="form-group">
                <label for="title">Referencia</label>
                <input type="text" class="form-control" name="edit_pos_refrence" value="{{$movement->pos_refrence}}">
                @if ($errors->has('pos_refrence'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('pos_refrence') }}</strong>
                </p>
                @endif
            </div>
            <label for="title">Fecha</label>
            <div class="form-group">
                <div class="input-group" id="edit_date">

                    <input type="text" class="form-control" name="edit_pos_date" value="{{$movement->pos_date}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar edit_movement-date-span"></span>
                    </div>
                </div>
                @if ($errors->has('edit_pos_date'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('edit_pos_date') }}</strong>
                </p>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
    @endrole
</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery('.edit_movement-date-span').on('click', function () {
            jQuery('#edit_date').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
    });
</script>
@endsection
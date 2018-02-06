@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user', 'sells')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('duepayment')}}" class="btn btn-primary">Regresar</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('saveeditduepayment', ['id' => $edit_payment->id])}}" id="edit_payment">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" class="form-control" name="edit_title" value="{{$edit_payment->title}}">
                @if ($errors->has('edit_title'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('edit_title') }}</strong>
                </p>
                @endif
            </div>

            <label for="title">Pendiente</label>
            <div class="form-group">
                <div class="input-group" id="edit_duedate">

                    <input type="text" class="form-control" name="edit_duedate" value="{{$edit_payment->duedate}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar edit_payment-date-span"></span>
                    </div>
                </div>
                @if ($errors->has('edit_duedate'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('edit_duedate') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="title">Referencia</label>
                <input type="edit_reference" class="form-control" name="edit_reference" value="{{$edit_payment->reference}}">
                @if ($errors->has('edit_reference'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('edit_reference') }}</strong>
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
        jQuery('.edit_payment-date-span').on('click', function () {
            jQuery('#edit_duedate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
    });
</script>
@endsection

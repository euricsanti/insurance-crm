/* Copyright © To Atul Sharma, all logic and code development belongs to his person and all involved in this proyect.
This code can be used to public or private proyects, with Creative Commons Law
Proyect belongs to Celeste Multimedia ©, for more information contact at www.celestemultimedia.com.do
*/
/* Here you can edit the due payment blade for adding a new one */

@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('duepayment')}}" class="btn btn-primary">Regresar</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('addduepayment')}}" id="add_due_payment">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title">Titulo</label>
                <input type="text" class="form-control" name="title" value="{{old('title')}}">
                @if ($errors->has('title'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('title') }}</strong>
                </p>
                @endif
            </div>

            <label for="title">Fecha de pago</label>
            <div class="form-group">
                <div class="input-group" id="duedate">

                    <input type="text" class="form-control" name="duedate" value="{{old('duedate')}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar payment-date-span"></span>
                    </div>
                </div>
                @if ($errors->has('duedate'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('duedate') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="reference">Referencia</label>
                <input type="text" class="form-control" name="reference" value="{{old('reference')}}">
                @if ($errors->has('reference'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('reference') }}</strong>
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
        jQuery('.payment-date-span').on('click', function () {
            jQuery('#duedate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
    });
    @endsection
</script>

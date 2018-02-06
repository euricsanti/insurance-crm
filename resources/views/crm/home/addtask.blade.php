@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user','sells', 'collect', 'cashier')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('homedaily')}}" class="btn btn-primary">Retroceder</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('addtask')}}" id="tasknote_form">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="comment">Agregar Tarea</label>
                <textarea class="form-control" rows="5" name="tasknote" id="tasknote">{{old('tasknote')}}</textarea>
                @if ($errors->has('tasknote'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('tasknote') }}</strong>
                </p>
                @endif
            </div>
			<div class="form-group">
                <label for="due_date">Fecha de vencimiento</label>
				<input type="text" name="due_date" value="{{old('due_date')}}"  >
                @if ($errors->has('due_date'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('due_date') }}</strong>
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

	jQuery(document).ready(function(){
		jQuery('input[name="due_date"]').mask("0000-00-00");
		jQuery('input[name="due_date"]').datetimepicker({
			format: 'YYYY-MM-DD'
		});
	});

</script>

@endsection

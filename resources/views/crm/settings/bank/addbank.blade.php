@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('banksview')}}" class="btn btn-primary">Regresar</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('addbank')}}" id="add_bank">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="type_of_policy">Nombre del banco</label>
                    <input type="text" class="form-control" name="bank_name" value="{{old('bank_name')}}">
                    @if ($errors->has('bank_name'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('bank_name') }}</strong>
                    </p>
                    @endif
            </div>
			 <div class="form-group">
                <label for="bk_account_number">Cuenta no</label>
                    <input type="text" class="form-control" name="bk_account_number" value="{{old('bk_account_number')}}">
                    @if ($errors->has('bk_account_number'))
                    <p class="alert">
                        <strong class="text-danger">{{ $errors->first('bk_account_number') }}</strong>
                    </p>
                    @endif
            </div>
            <button type="submit" class="btn btn-primary">Agregar Banco</button>
        </form>
    </div>
    @endrole
</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
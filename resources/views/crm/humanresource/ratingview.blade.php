@extends('crm.layouts.default')

@section('content')


<div class="row">
    @role('super_user','owner')
    @if(Session::has('success'))
    <div class="alert-box success">
        <h2 class="text-center text-success">{{ Session::get('success') }}</h2>
    </div>  
    @endif
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p><a href="{{route('humanresource')}}" class="btn btn-primary btn-sm">Regresar</a></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('rateuser')}}" id="rate_user">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="rating">Valoracion</label>
                <select class="form-control" name="rating" id="rating">
                    <option value="">Por favor seleccion</option>
                    @for($i=0;$i<=10;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor

                </select>
                @if ($errors->has('rating'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('rating') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="rating_note">Nota</label>
                <textarea class="form-control"  name="rating_note" rows="10" cols="20">{{old('rating_note')}}</textarea>
                @if ($errors->has('rating_note'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('rating_note') }}</strong>
                </p>
                @endif
            </div>
            <input type="hidden" name="dependant_id" value="{{$id}}">
            <button type="submit" class="btn btn-primary btn-sm">Valorar</button>
        </form>
    </div>
    @endrole
</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
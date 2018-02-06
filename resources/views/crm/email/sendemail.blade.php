@extends('crm.layouts.default')

@section('content')


<div class="row">
    @if(Session::has('success'))
    <div class="alert-box success">
        <h2 class="text-center text-success">{{ Session::get('success') }}</h2>
    </div>  
    @endif
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form method="POST" action="{{route('dispatchemail')}}" id="dispatchemail">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="toemail">Para</label>
                <input type="text" class="form-control" name="toemail" value="{{old('toemail')}}">
                @if ($errors->has('toemail'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('toemail') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="subject">Asunto</label>
                <input type="text" class="form-control" name="subject" value="{{old('subject')}}">
                @if ($errors->has('subject'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('subject') }}</strong>
                </p>
                @endif
            </div>
            <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea  class="form-control" name="message" rows="10" cols="50">{{old('message')}}</textarea>
                @if ($errors->has('message'))
                <p class="alert">
                    <strong class="text-danger">{{ $errors->first('message') }}</strong>
                </p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Enviar correo</button>
        </form>
    </div>
</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
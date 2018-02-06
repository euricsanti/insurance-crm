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

    <table id="listinbox" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Envía</th>
                <th>Para</th>
                <th>Apellido</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mailobject as $mail)
            <tr>
                <td>{{$mail['fromName']}}</td>
                <td>{{$mail['toString']}}</td>
                <td>{{$mail['subject']}}</td>
                <td><a href="{{route('viewmail',['mailid'=> $mail['mailid']])}}" class="btn btn-info btn-sm">Ver</a></td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>


@endsection

@section('javascripts')
<script>
    jQuery(document).ready(function () {
        jQuery('#listinbox').DataTable({
            "processing": true,
            "serverSide": false,
            "ordering": true,
            "paging": true,
            "searching": true
        });
    });
</script>
@endsection
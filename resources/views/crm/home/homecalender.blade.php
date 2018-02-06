@extends('crm.layouts.default')

@section('content')

<script type="text/javascript" src="{{  URL::asset('/js/fullcalendar.min.js') }}"></script>

{!! $calendar->calendar() !!}
{!! $calendar->script() !!}

@endsection
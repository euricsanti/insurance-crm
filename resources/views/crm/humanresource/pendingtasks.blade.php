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
        <table  class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Task Description</th>
                    <th>Due date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pending_tasks as $tasks)
                <tr>
                    <td> {{ $tasks->tasknote }} </td>
                    <td> {{ $tasks->due_date }} </td>
                    <td> {{ ucfirst($tasks->status) }} </td>
                </tr>
                @empty
                <tr>
                    <td class="text-warning"><b>No se han encontrado registros</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination"> {{ $pending_tasks->render() }} </div>
    </div>

</div>


@endsection

@section('javascripts')
<script>

</script>
@endsection
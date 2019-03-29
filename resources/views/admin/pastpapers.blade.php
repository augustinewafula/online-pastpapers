@extends('layouts.app')

@section('title')
    <title>Pastpapers - Online Pastpapers</title>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">    
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-clipboard"></i> Pastpapers</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('pastpapers.index') }}">Pastpapers</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">  
                    <p>
                        <a class="btn btn-primary icon-btn float-right" style="margin-left: 10px" href="{{ route('pastpapers.create') }}"><i class="fa fa-plus"></i>Add Pastpaper</a>
                    </p><br><br>
                <div class="tile-body">
                <table class="table table-hover table-bordered" id="adminsTable">
                    <thead>
                    <tr>
                        <th>Unit name</th>
                        <th>Unit code</th>
                        <th>Programme</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($pastpapers as $pastpaper)
                        <tr class="item">
                            <td>{{ $pastpaper->unit_name }}</td> 
                            <td>{{ $pastpaper->unit_code }}</td>
                            <td>{{ $pastpaper->programme }}</td>
                            <td></td>
                            {{-- <td>
                            <a class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Compose a message to {{$group->name}} group" data-placement="left" href="{{ route('admin_compose_message',['to'=>$group->slug]) }}"><i class="fa fa-comment-o" style="font-size: 20px;"></i></a>
                            <a href="{{ route('admin_edit_group', ['slug'=>$group->slug]) }}" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil" style="font-size: 20px;"></i></a>
                            <button onClick="deleteBtn({{$group->id}})" data-toggle="tooltip" title="Delete group" data-placement="right" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                            <form id="delete_form_{{$group->id}}" action="{{ route('admin_delete_group') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{Crypt::encrypt($group->id)}}">
                            </form> 
                            </td> --}}
                        </tr>                        
                        @endforeach                  
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/buttons.bootstrap4.min.js') }}"></script>
<script>
    $('#adminsTable').DataTable();
</script>
@if (session('status'))
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap-notify.min.js') }}"></script>
    <script type="text/javascript">
      $.notify({
            title: "Success : ",
            message: "{{ session('status') }}",
            icon: 'fa fa-check' 
          },{
            type: "info"
      });
    </script>        
@endif   
@endsection
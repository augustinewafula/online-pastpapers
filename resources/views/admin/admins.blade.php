@extends('layouts.app')

@section('title')
    <title>Admins - Online Pastpapers</title>
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Home</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">Admins</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">  
                    <p>
                        <a class="btn btn-primary icon-btn float-right" style="margin-left: 10px" href="{{ route('admins.create') }}"><i class="fa fa-plus"></i>Add admin</a>
                    </p><br><br>
                <div class="tile-body">
                <table class="table table-hover table-bordered" id="adminsTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Admin type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr class="item">
                            <td>{{ $admin->name }} @if ($admin->email==Auth('admin')->user()->email)
                                (You)
                            @endif</td> 
                            <td>{{ $admin->email }}</td> 
                            <td>
                            @if ($admin->type==1)
                                Normal
                            @else
                                Super
                            @endif
                            </td> 
                            <td>
                                @if ($admin->type==1)
                                <button onClick="deleteBtn('{{$admin->id}}')" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash" style="font-size: 20px;"></i></button>
                                <form id="delete_form_{{$admin->id}}" action="{{ route('admins.destroy',['id'=>$admin->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                @endif                                
                            </td>
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
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script>
    $('#adminsTable').DataTable();
    function deleteBtn(id) {    
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                form ="delete_form_"+id;
                    document.getElementById(form).submit();
            }   
            
        });
    }
</script>
@if (session('status'))
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
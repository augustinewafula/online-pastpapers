@extends('layouts.app')

@section('title')
    <title>Departments - Online Pastpapers</title>
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-clipboard"></i> Edit Department</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.destroy', ['slug'=>$department->slug]) }}">{{$department->slug}}</a></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">  
                <form method="POST" autocomplete="off" action="{{ route('departments.update', ['slug'=>$department->slug]) }}" enctype="multipart/form-data">
                    @csrf  
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name" class="{{ $errors->has('question') ? ' text-danger' : '' }}">Department Name</label>
                                <input type="text" id="name" name="name" value="{{$department->name}}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="new-text" placeholder="Department Name" required>  
                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif          
                            </div>
                        </div>
                    </div>      
                    <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">Update</button>                    
                </form> 
            </div>
        </div>
    </div>
</main>
@endsection
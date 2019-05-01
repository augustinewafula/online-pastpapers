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
            <h1><i class="fa fa-users"></i> Add Admin</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">Admins</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admins.create') }}">Add</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">  
                <form method="POST" autocomplete="off" action="{{ route('admins.store') }}" enctype="multipart/form-data">
                    @csrf  
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="name" class="{{ $errors->has('question') ? ' text-danger' : '' }}">Name</label>
                                <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="new-text" placeholder="Name of new admin" required>  
                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif          
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-7"> 
                            <div class="form-group">
                                <label class="control-label {{ $errors->has('question') ? ' text-danger' : '' }}">Email</label>
                                <input v-validate class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" value="{{ old('email') }}" placeholder="Email address" required>
                                <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('email') }}</strong></span>
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif  
                            </div>  
                        </div>
                    </div>
                    <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">Save</button>                    
                </form> 
            </div>
        </div>
    </div>
</main>
@endsection
@extends('beautymail::templates.ark')
 
@section('content')
 
    @include('beautymail::templates.ark.heading', [
        'heading' => 'Added as admin',
        'level' => 'h1'
    ])
 
    @include('beautymail::templates.ark.contentStart')
 
        <h1>Hi, {{$name}}</h1>
        <p>You were added as an admin at Online Pastpapers.</p>
        <h4 class="secondary"><strong>Your login credentials are:</strong></h4>      
        <p><strong>Email: </strong> {{$email}}</p>
        <p><strong>Password: </strong> {{$password}}</p><br>
        <p>Follow the link below to login</p>
        <a href="{{ route('admin_login_form') }}">{{ route('admin_login_form') }}</a>
    @include('beautymail::templates.ark.contentEnd')
 
@stop
@extends('layouts.app')

@section('title')
    <title>Pastpapers - Online Pastpapers</title>
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-clipboard"></i> Add Pastpaper</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('pastpapers.index') }}">Pastpapers</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pastpapers.create') }}">Add</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">  
                <form method="POST" autocomplete="off" action="{{ route('pastpapers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                                <label for="department" class="{{ $errors->has('department') ? ' text-danger' : '' }}">Department</label>
                                <select class="form-control{{ $errors->has('programme') ? ' is-invalid' : '' }}" id="department" name="department" required>
                                        <option value="">-- Select Department where the pastpaper belongs --</option>
                                        <option value="Architecture & Civil Engineering">Architecture &amp; Civil Engineering</option>
                                        <option value="Biology">Biology</option>
                                        <option value="Chemical Engineering">Chemical Engineering</option>
                                        <option value="Chemistry">Chemistry</option>
                                        <option value="Computer Science">Computer Science</option>
                                        <option value="Economics">Economics</option>
                                        <option value="Education">Education</option>
                                        <option value="Electrical & Electronic Engineering">Electrical &amp; Electronic Engineering</option>
                                        <option value="Foreign Languages Centre">Foreign Languages Centre</option>
                                        <option value="Health">Health</option>
                                        <option value="Mathematical Science">Mathematical Science</option>
                                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                                        <option value="MN">Mechanical Engineering</option>
                                        <option value="Natural Sciences">Natural Sciences</option>
                                        <option value="Pharmacy & Pharmacology">Pharmacy &amp; Pharmacology</option>
                                        <option value="Physics">Physics</option>
                                        <option value="Politics, Languages &amp; International Studies">Politics, Languages &amp; International Studies</option>
                                        <option value="Psychology">Psychology</option>
                                        <option value="Social & Policy Sciences">Social &amp; Policy Sciences</option>            
                                </select>
                                @if ($errors->has('department'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="programme" class="{{ $errors->has('programme') ? ' text-danger' : '' }}">Programme</label>
                                <select class="form-control{{ $errors->has('programme') ? ' is-invalid' : '' }}" id="programme" name="programme" required>
                                    <option value="">-- Study level where the pastpaper belongs --</option>
                                    <option value="Phd">Phd</option>
                                    <option value="Masters">Masters</option>
                                    <option value="Degree">Degree</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Certificate">Certificate</option>
                                </select>
                                @if ($errors->has('programme'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('programme') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="unit_name" class="{{ $errors->has('question') ? ' text-danger' : '' }}">Unit Name</label>
                                <input type="text" id="unit_name" name="unit_name" class="form-control{{ $errors->has('unit_name') ? ' is-invalid' : '' }}" autocomplete="new-text" placeholder="Unit Name" required>  
                                @if ($errors->has('unit_name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('unit_name') }}</strong>
                                    </span>
                                @endif          
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="unit_code" class="{{ $errors->has('question') ? ' text-danger' : '' }}">Unit Code</label>
                                <input type="text" id="unit_code" name="unit_code" class="form-control{{ $errors->has('question') ? ' is-invalid' : '' }}" autocomplete="new-text" placeholder="Unit Code" required>    
                                @if ($errors->has('unit_code'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('unit_code') }}</strong>
                                    </span>
                                @endif        
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="question" class="{{ $errors->has('question') ? ' text-danger' : '' }}">Question file</label>
                                <input type="file" name="question" class="form-control{{ $errors->has('question') ? ' is-invalid' : '' }}" accept=".pdf,.docx" id="question" aria-describedby="questionHelp" required>
                                @if ($errors->has('question'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('question') }}</strong>
                                    </span>
                                @endif
                                <small class="form-text text-muted" id="questionHelp">Browse and choose the question pastpaper.</small>
                            </div>
                            <div class="animated-checkbox">
                            <label>
                                <input type="checkbox" v-model="answer" name="answer_checkbox"><span class="label-text">Answer to the pastpaper will be provided too</span>
                            </label>
                            </div>
                        </div>     
                    </div>     
                    <div class="row" style="display: none;" v-show="answer">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputFile" class="{{ $errors->has('answer') ? ' text-danger' : '' }}">Answer file</label>
                                <input type="file" name="answer" class="form-control{{ $errors->has('answer') ? ' is-invalid' : '' }}" aria-describedby="answerHelp" id="answer" :required="answer">
                                @if ($errors->has('answer'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('answer') }}</strong>
                                    </span>
                                @endif
                                <small class="form-text text-muted" id="questionHelp">Browse and choose the answer pastpaper.</small>
                            </div>  
                        </div>          
                    </div>     
                    <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">Submit</button>                    
                </form> 
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    var app = new Vue({ 
    el: '#app',
    data: {
        answer: false
    }
});
</script>
    
@endsection
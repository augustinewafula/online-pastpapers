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
                            <div class="form-group">
                                <label for="unit" class="{{ $errors->has('unit') ? ' text-danger' : '' }}">Unit</label>
                                <select class="form-control{{ $errors->has('unit') ? ' is-invalid' : '' }}" id="unit" name="unit" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach ($units as $unit)
                                    <option value="{{$unit->slug}}">{{$unit->code}} - {{$unit->name}}</option>                                        
                                    @endforeach
                                </select>
                                @if ($errors->has('unit'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('unit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <label for="from" class="{{ $errors->has('from') ? ' text-danger' : '' }}">Period</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input class="form-control" id="from" name="from" type="text" placeholder="From">
                                    @if ($errors->has('from'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('from') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-4">                                    
                                    <input class="form-control" id="to" name="to" type="text" placeholder="To">
                                    @if ($errors->has('to'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('to') }}</strong>
                                        </span>
                                    @endif
                                </div>
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
                            {{-- <div class="animated-checkbox">
                            <label>
                                <input type="checkbox" v-model="answer" name="answer_checkbox"><span class="label-text">Answer to the pastpaper will be provided too</span>
                            </label>
                            </div> --}}
                        </div>     
                        <div class="col-md-1"></div>
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
                    {{-- <div class="row" style="display: none;" v-show="answer">
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
                    </div>      --}}
                    <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">Submit</button>                    
                </form> 
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>    
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap-datepicker.min.js') }}"></script>   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css"></script>   
<script>
    $(document).ready(function() {
        $('#unit').select2();
     
        var startDate = new Date();
        var fechaFin = new Date();
        var FromEndDate = new Date(); 
        var ToEndDate = new Date();    
        
        $("#from").datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'M yyyy',
            orientation: 'bottom'
        }).on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            $('.to').datepicker('setStartDate', startDate);
        }); 
        
        $('#to').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'M yyyy',
            orientation: 'bottom'
        }).on('changeDate', function(selected){
            FromEndDate = new Date(selected.date.valueOf());
            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
            $('.from').datepicker('setEndDate', FromEndDate);
        });  
            
    });

    var app = new Vue({ 
        el: '#app',
        data: {
            answer: false
        }
    });
</script>
    
@endsection
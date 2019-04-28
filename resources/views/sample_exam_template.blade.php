<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$unit}}</title>
</head>
<body>
    <div id="pastpaper-content">
        <center>
            <img src="{{ asset('img/logo.png') }}" width="120" alt="logo">
            <h4>ONLINE PASTPAPERS</h4>
            <h4>{{$unit}}</h4>
        </center>
            {{-- <div class="row">
                <div class="col-md-6">
                    <h4 style="padding-left: 110px">JANUARY 2019</h4>
                </div>
                <div class="col-md-6" style="padding-left: 150px">                        
                    <h4>TIME: 2 HOURS</h4>
                </div>
            </div> --}}
        <center>
            <hr>
            <h4>INSTRUCTIONS: ANSWER QUESTION ONE [COMPULSORY] AND ANY OTHER TWO QUESTIONS</h4>
            <hr>
        </center>
        <div style="padding-left: 50px">
            <h4>QUESTION ONE [30 MARKS]</h4>
            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;">
                @foreach ($questions['question_one'] as $question)
                    {{$question['question']}}
                @endforeach    
            </p>
            <br>

            <h4>QUESTION TWO [20 MARKS]</h4>
            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;">
                @foreach ($questions['question_two'] as $question)
                    {{$question['question']}}
                @endforeach       
            </p>
            <br>

            <h4>QUESTION THREE [20 MARKS]</h4>
            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;">
                @foreach ($questions['question_three'] as $question)
                    {{$question['question']}}
                @endforeach        
            </p>
            <br>

            <h4>QUESTION FOUR [20 MARKS]</h4>
            <p style="white-space: pre-line; padding-left: 20px; font-size: 18px;">
                @foreach ($questions['question_four'] as $question)
                    {{$question['question']}}
                @endforeach        
            </p>
        </div> 
    </div>   
</body>
</html>
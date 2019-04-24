<?php

namespace App\Http\Controllers;
use App\Unit;
use App\Question;
use App\Pastpaper;
use DB;
use Illuminate\Http\Request;

class SampleExamController extends Controller
{
    public function index()
    {
        return view('sample_exam');
    }

    public function generate($keyword){
         // check if user selected unit from dropdown, if so we can easily obtain unit code
        if (strpos($keyword, '-')) {
            $unti_code = trim(explode("-", $keyword, 2)[0]);
        }else{
            $unit = Unit::select('id','name','code')
                        ->where('name', 'like', '%'.$keyword.'%')
                        ->orWhere('code', 'like', '%'.$keyword.'%')
                        ->first();
            $unti_code = $unit->code;
        }
        $all_questions = [];

        for ($i=1; $i <= 4; $i++) { 
            if ($i==1) {
                $total_marks = 30;
            }else{
                $total_marks = 20;
            }
            $question = $this->getQuestions($unti_code, $i, $total_marks);
            $all_questions[] = $question;
        }
        return $all_questions;

    }

    public function getQuestions($unit_code,$question_number,$total_marks){
        $questions = Question::select('questions.id','questions.question','questions.marks')
                             ->join('pastpapers','pastpapers.id','questions.pastpaper_id')
                             ->join('units','units.id','pastpapers.unit_id')
                             ->where('question_number',$question_number)
                             ->where('units.code',$unit_code)
                             ->take(40)
                             ->inRandomOrder()
                             ->get();

        $filtered_questions = [];
        $sum_marks = 0;
        $counter = 0;
        foreach ($questions as $single_question) {         
            if ($sum_marks<=$total_marks && ($single_question->marks+$sum_marks<=$total_marks)) {
                $marks = $single_question->marks;
                $sum_marks+= $marks;

                $filtered_questions[$counter]['question'] = $this->toAlpha($counter).') '.$single_question->question;
                $filtered_questions[$counter]['id'] = $single_question->id;
                $counter++;
            }   
        }
        return $filtered_questions;

    }

    function toAlpha($data){
        $alphabet =   array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $alpha_flip = array_flip($alphabet);
        if($data <= 25){
          return $alphabet[$data];
        }
        elseif($data > 25){
          $dividend = ($data + 1);
          $alpha = '';
          $modulo;
          while ($dividend > 0){
            $modulo = ($dividend - 1) % 26;
            $alpha = $alphabet[$modulo] . $alpha;
            $dividend = floor((($dividend - $modulo) / 26));
          } 
          return $alpha;
        }
    }

}

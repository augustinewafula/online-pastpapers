<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\FileToText;
use App\Question;
use NumberFormatter;
use Illuminate\Support\Facades\Log;

class ExtractTextFromFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pastpaper_name,$pastpaper_extension,$path,$pastpaper_id;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_name,$file_extension,$pastpaper_id)
    {
        $this->pastpaper_name = $file_name;
        $this->pastpaper_extension = $file_extension;
        $this->pastpaper_id = $pastpaper_id;
        $this->path = storage_path('app/storage/pastpapers/');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pastpaper = new FileToText($this->pastpaper_name,$this->pastpaper_extension);
        $pastpaper_in_text = $pastpaper->convertToText();

         // take four questions
        for ($i=1; $i < 5; $i++) { 
            $this->getQuestions($i,$pastpaper_in_text);
        }
        return;
    }

    function getQuestions($number,$pastpaper_text_questions){
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $question_number = $f->format($number);
        $specific_number_questions = $this->extractTextFromString($pastpaper_text_questions,'question '.$question_number,12,'question');

        if(strlen($specific_number_questions)<50){
            //it is still heading of the pastpaper, probably its the word 'question one'. So we replace it with anything and repeat the search
            $pos = stripos($pastpaper_text_questions, 'question '.$question_number);
            if ($pos !== false) {
                $replace = "something";
                $pastpaper_text_questions = substr_replace($pastpaper_text_questions, $replace, $pos, strlen('question '.$question_number));
            }
            $specific_number_questions = stristr(substr($pastpaper_text_questions, stripos($pastpaper_text_questions, 'question '.$question_number) + 12), 'question', true);
        }
        for ($i=0; $i < 8; $i++) { 
            $character = $this->toAlpha($i);
            $hasMutipleQuestions = false;
            // check if the question letter exist first
            if (stripos($specific_number_questions, $character.')')) {
                $terminate_with = 'marks)';
                $single_question = trim($this->extractTextFromString($specific_number_questions,$character.')',2,$terminate_with));
                if (!$single_question) {
                    $terminate_with = 'marks]';
                    $single_question = trim($this->extractTextFromString($specific_number_questions,$character.')',2,$terminate_with));
                }
                //check if the question contains 'following' or 'below', if so it does not end at marks
                if (stristr($single_question, 'following') || stristr($single_question, 'below')){
                    $hasMutipleQuestions = true;
                    $next_character = $this->toAlpha($i+1);
                    $next_single_question = trim($this->extractTextFromString($specific_number_questions,$next_character.')',2,$terminate_with));
                    if (!$next_single_question) {
                        $next_single_question = trim($this->extractTextFromString($specific_number_questions,$next_character.')',2,$terminate_with));
                    }
                    //we make sure the next character question exists first, if it doest the question is the last on that number
                    if ($next_single_question) {
                        $single_question = trim($this->extractTextFromString($specific_number_questions,$character.')',2,$next_character.')'));
                    } else {
                        $single_question = trim($this->extractTextFromString($specific_number_questions,$character.')',2,'question '));
                    }  
                }
                // $question_number.$character.': '.$single_question.'</br>';
                if ($single_question && strlen($single_question)>10) {   
                    if ($terminate_with == 'marks)') {
                        $marks = trim(substr(substr($single_question, stripos($single_question, '(') + 1), 0, 2));
                    } else {
                        $marks = trim(substr(substr($single_question, stripos($single_question, '[') + 1), 0, 2));
                    }
                    $final_question = $single_question;
                    if (!$hasMutipleQuestions) {
                      $final_question = $single_question.' '.ucfirst($terminate_with);
                    }

                    // make sure the marks obtain is an integer
                    if (is_numeric($marks)) {
                        // inserting to db at this point
                        $question = new Question();
                        $question->pastpaper_id = $this->pastpaper_id;
                        $question->question_number = $number;
                        $question->question = $final_question;
                        $question->marks = $marks;
                        $question->save();
                    }else{
                        Log::info($this->pastpaper_name.': Number '.$number.' marks('.$marks.') is not a numeric value');
                    }
                    // file_put_contents($this->path.$question_number.$character.'.txt', $final_question);
                }
               
            }          
        }
        return;
    }

    function extractTextFromString($whole_string,$from,$from_count,$to){
      return stristr(substr($whole_string, stripos($whole_string, $from) + $from_count), $to, true);

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

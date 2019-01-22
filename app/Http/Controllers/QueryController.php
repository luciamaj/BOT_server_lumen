<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Query;
use App\Keyword;
use App\Question;
use SentimentAnalysis;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function checkKeywords(Request $request)
    {
        $question = $request->content;
        $userQuestion = new Question;
        $userQuestion->content = $question;

        $ip = $request->ip();

        $userQuestion->ip = $ip;
        $userQuestion->is_dev = false;
        $userQuestion->save();
        $analysis = new SentimentAnalysis();

        $negativeScore = $analysis->isNegative($question);
        $question = preg_replace('/[^a-z0-9]+/i', '_', $question);

        $question = strtolower($question);    

        $questions = explode("_", $question);
        $keywordsAll = Keyword::all();
        $keywords = Keyword::pluck('word');
        $arrayFound = [];
        
        for($i = 0; $i < sizeof($keywords); $i++){
            array_push($arrayFound, 0);
        }
        
        for($i = 0; $i < sizeof($keywords); $i++) {
            $a = $keywords[$i];
            $a = strtolower($a); 
            for($k = 0; $k < sizeof($questions); $k++) {
                if($questions[$k] === $keywords[$i]) {
                    $arrayFound[$i]++;
                } 
            }
        }

        $max = 0;
        for($i = 0; $i < sizeof($arrayFound); $i++) {
            if($arrayFound[$i] > $max) {
                $max = $arrayFound[$i];
            }
        }

        for($i = 0; $i<sizeof($arrayFound); $i++){
            if($arrayFound[$i]){
                $index = $i;
            }
        }

        $index = 0;
        for($i = 0; $i<sizeof($arrayFound); $i++){
            if($max == $arrayFound[$i]){
                $index = $i;
            }
        } 
        
        $keywordFound = $keywordsAll[$index];
        if($negativeScore == true) {
            $object = (object) ['content' => 'negative'];
            return response()->json($object);
        }
        else {
            if($max != 0) {
                $answer = Answer::find($keywordFound->answer_id);
                return response()->json($answer);
            }
            else {
                $object = (object) ['content' => 'error'];
                return response()->json($object);
            }
        }
    } 
}
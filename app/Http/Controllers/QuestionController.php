<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function showAllQuestions()
    {
        return response()->json(Answer::all());
    }
    
    public function create(Request $request)
    {
        $question = new Question;
        $question->content = $request->content;
        $question->is_dev = true;
        $question->ip = $request->ip;
        $question->save();

        return response()->json($question);
    }

    public function showGroupedQuestions() {
        $questions = Question::all()->sortByDesc('created_at')->groupBy('ip');

        return response()->json($questions);
    }

    public function createUserQ(Request $request)
    {
        $question = new Question;
        $question->content = $request->content;
        $question->is_dev = false;
        $question->ip = $request->ip();
        $question->save();

        return response()->json($question);
    }

    public function getLast(Request $request)
    {
        $ip = $request->ip();
        
        $question = Question::orderBy('created_at', 'desc')->where('ip', '=', $ip)->first();

        return response()->json($question);
    }
}
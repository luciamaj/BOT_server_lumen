<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Storage;
use File;

class AnswerController extends Controller
{
    public function showAllAnswers()
    {
        return response()->json(Answer::all());
    }

    public function create(Request $request)
    {   
        $code = $request->file('code');
        if($code) {
            $extension = $code->getClientOriginalExtension();
            Storage::disk('public')->put($code->getFilename().'.'.$extension,  File::get($code));
        }
        $answer = new Answer;
        $answer->content = $request->input('content');
        $answer->mime = $code->getClientMimeType();
        $answer->original_filename = $code->getClientOriginalName();
        $answer->filename = $code->getFilename().'.'.$extension;
        $answer->save();

        return response()->json($answer);
    }
}
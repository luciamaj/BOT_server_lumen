<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Keyword;
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
        $answer = new Answer;
        $code = $request->file('code');
        if($code) {
            $extension = $code->getClientOriginalExtension();
            Storage::disk('public')->put($code->getFilename().'.'.$extension,  File::get($code));
            $answer->mime = $code->getClientMimeType();
            $answer->original_filename = $code->getClientOriginalName();
            $answer->filename = $code->getFilename().'.'.$extension;
        }
        $answer->content = $request->input('content');
        $answer->save();

        return response()->json($answer);
    }

    public function destroy($id) {
        $answer = Answer::find($id);
        $answer->delete();
        return response()->json('deleted');
    }

    public function showKeywords($id) {
        $answer = Answer::find($id);
        $answer_id = $answer->id;
        $keywords = Keyword::where('answer_id', '=', $answer_id)->get();
        return response()->json($keywords);
    }
}
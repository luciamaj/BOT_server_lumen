<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{

    public function create(Request $request)
    {
        $keyword = Keyword::create($request->all());

        return response()->json($keyword, 201);
    }

    public function destroy(Request $request)
    {
        $keywords = $request->keywords;
        Keyword::destroy($keywords);

        return response()->json($keywords);
    }
}
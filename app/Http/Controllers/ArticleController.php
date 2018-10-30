<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

class ArticleController extends Controller
{
    /**
    评论
     */
    public function show($id)
    {

        return view('article/show')->withArticle(Article::with('hasManyComments')->find($id));
    }
}

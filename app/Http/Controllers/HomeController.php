<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * 首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        //return view('home');
       // return view('home')->withArticles(\App\Article::all());
        return view('home')  ->with('articles', \App\Article::all());
    }

    /**
     测试
     * https://github.com/johnlui/Learn-Laravel-5/issues/16
     */
    function  test(){
       // 找到 id 为 2 的文章打印其标题
        $article = Article::find(2);
        echo $article->title;
    }
}

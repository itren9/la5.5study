<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;
use Mail;

class ArticleController extends Controller
{
    /**
    评论
     */
    public function show($id)
    {

       // return view('article/show')->withArticle(Article::with('hasManyComments')->find($id));
    }
    /**
      测试发送邮件
     */
    public function mailText()
    {
        //纯文本方式发送邮件
        echo 11;
        Mail::raw('邮件内容', function ($message) {
            $message->from("m18500975726@163.com", '发件人的名称');
            $message->subject('邮件主题');
            $message->to('1194261298@qq.com');
        });
    }
    public function mailHtml(){

            //html 方式发送邮件
            echo 22;
            Mail:send('article.mail',['name'=>"内容"],function ($message){
            $message->from("m18500975726@163.com", '发件人的名称2');
            $message->subject('邮件主题2');
                $message->to('1194261298@qq.com');
            });
        }


}

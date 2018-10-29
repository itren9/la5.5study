<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }
    /**
     文章列表
     *
     * 关于withArticles的问题，实际上view里面并没有定义一个withArticles的函数。这个函数是动态绑定出来的。
     * 源代码位于learnlaravel5/vendor/laravel/framework/src/Illuminate/View/View.php大概380行左右的样子，
        view('home')->withArticles(\App\Article::all())等价于view('home')->with('articles', \App\Article::all())。
     */
    public function index()
    {
        return view('admin/article/index')->withArticles(Article::all());
    }
    public function create()
    {
        return view('admin/article/create');
    }

    /***
     * @param Request $request
     * 添加  store
     * @return
     */
    public function store(Request $request) // Laravel 的依赖注入系统会自动初始化我们需要的 Request 类
    {
        // 数据验证
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255', // 必填、在 articles 表中唯一、最大长度 255
            'body' => 'required', // 必填
        ]);

        // 通过 Article Model 插入一条数据进 articles 表
        $article = new Article; // 初始化 Article 对象
        $article->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 article 的 title 属性
        $article->body = $request->get('body'); // 同上
        $article->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 article 的 user_id 属性

        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($article->save()) {
            return redirect('admin/articles'); // 保存成功，跳转到 文章管理 页
        } else {
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /***
     * @param $id
     * 删除  destroy
     * 大家可能注意到了这句代码 {{ method_field('DELETE') }}，这是什么意思呢？这是 Laravel 特有的请求处理系统的特殊约定。
     * 虽然 DELETE 方法在 RFC2616 中是可以携带 body 的（甚至 GET 方法都是可以携带的），但是由于历史的原因，
     * 不少 web server 软件都将 DELETE 方法和 GET 方法视作不可携带 body 的方法，有些 web server 软件会丢弃 body，
     * 有些干脆直接认为请求不合法拒绝接收。所以在这里，Laravel 的请求处理系统要求所有非 GET 和 POST 的请求全部通过 POST 请求来执行，
     * 再将真正的方法使用 _method 表单字段携带给后端。
     * 上面小作业中的小坑便是这个，PUT/PATCH 请求也要通过 POST 来执行。
     *
     *
     *
     *
     * @return $this
     */
    public function destroy($id)
    {
        Article::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }

    /***
     * 修改_读取老数据
     *
     */
     public  function  edit($id){
         $article = Article::find($id);
        // print_r($article);
         return view('admin/article/update',['article'=>$article]);//你可以使用 「中括号」 包住变量将数据传递给 Blade 视
       //  return view('admin/article/edit')->withArticle(Article::find($id));
     }
     /**
       修改操作
      */
      public function update(Request $request,$id) // Laravel 的依赖注入系统 会自动初始化我们需要的 Request 类
      {
          // 数据验证
          $this->validate($request, [
              'title' => 'required|unique:articles,title,'.$id.'|max:255', // 必填、在 articles 表中唯一但去除自己对对比、最大长度 255
              'body' => 'required', // 必填
          ]);


          $article = Article::find($id);//查询出所有对象
          $article->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 article 的 title 属性
          $article->body = $request->get('body'); // 同上
          $article->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 article 的 user_id 属性

          // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
          if ($article->save()) {
              return redirect('admin/articles'); // 修改成功，跳转到 文章管理 页
          } else {
              // 保存失败，跳回来路页面，保留用户的输入，并给出提示
              return redirect()->back()->withInput()->withErrors('修改失败！');
          }




      }
















    public function  test(){
        $user =  DB::table('articles')->get();
        echo $user->id;
    }
}

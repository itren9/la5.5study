<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
评论
 */
class Comment extends Model
{
    //
    protected $fillable = ['nickname', 'email', 'website', 'content', 'article_id'];
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
 
    public function store(Post $post, Request $request)
    {     

        
        
         $post->comments()->create([
             'user_id' => $request->user()->id,
             'comment' => $request->comment
         ]);
        
        // if(!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()){
        //     Mail::to($post->user)->send(new PostLiked(auth()->user(), $post));
        // }     
         return back();
    }
    
    public function destroy(Comment $comment, Request $request)
    {
        $request->user()->comments()->where('id', $comment->id)->delete();
        return back();
    }
}

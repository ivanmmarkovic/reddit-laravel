<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;
use App\Comment;

use App\User;

class CommentsController extends Controller
{
    //
    public function store(Request $request, Post $post)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->comment = $request['comment'];
        $user = $request->user();
        $user->comments()->save($comment);

        return redirect()->route('post', ['post' => $post->id])->with(['message' => 'Comment created']);
    }

    public function commentsuser(User $user)
    {
        $comments = $user->comments;
        return view('comments.commentsuser', compact('user', 'comments'));
    }

    public function delete(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with(['message' => 'Comment deleted']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;    

use App\User;
use App\Post;
use DB;

class PostsController extends Controller
{
    //

    public function index()
    {
        $posts = Post::all();
        return view('welcome', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required',
            'description' => 'required|max:100'
        ]);
        $post = new Post();
        $post->title = $request['title'];
        $post->link = $request['link'];
        $post->description = $request['description'];
        $user = $request->user();
        $user->posts()->save($post);

        return redirect()->route('welcome')->with(['message' => 'Post created']);
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function postsuser(User $user)
    {
        $posts = $user->posts;
        return view('posts.postsuser', compact('user', 'posts'));
    }

    public function delete(Request $request, Post $post)
    {
        DB::delete('delete from comments where post_id = ?', [$post->id]);
        $post->delete();
        return redirect()->route('profile', ['profile' => $request->user()->id])->with(['message' => 'Post and comments deleted']);
    }

    public function vote(Request $request)
    {
        $userId = $request['userId'];
        $postId = $request['postId'];
        $voteType = $request['voteType'];
        $token = $request['_token'];

        // query below returns vote_type('up' or 'down') or null
        $vote = DB::table('votes')->where([
            ['user_id', "=", $request['userId']],
            ['post_id', "=", $request['postId']]
        ])->value('vote_type');

        // if user didn't vote
        if (!$vote) {
          DB::table('votes')->insert([
              'post_id' => $postId,
              'user_id' => $userId,
              'vote_type' => $voteType
          ]);
          $post = Post::find($postId);
          if ($voteType == "up") {
              $postVotesUp = $post->votes_up;
              $postVotesUp = $postVotesUp + 1;
              $post->votes_up = $postVotesUp;
              $postVotesDown = $post->votes_down;
              $result = $postVotesUp - $postVotesDown;
              $post->result = $result;
              $post->update();
          }
          else {
              $postVotesDown = $post->votes_down;
              $postVotesDown = $postVotesDown + 1;
              $post->votes_down = $postVotesDown;
              $postVotesUp = $post->votes_up;
              $result = $postVotesUp - $postVotesDown;
              $post->result = $result;
              $post->update();
          }
          $result = $post->votes_up - $post->votes_down;
          $up = $post->votes_up;
          $down = $post->votes_down;
          return response()->json(['result' => $result, 'up' => $up, 'down' => $down], 200);
        }
        // if user has already voted
        if ($vote == $voteType) {
            return response()->json(['warning' => 'You can not vote twice(up or down) for same post'], 200);
        }
        else {
            $post = Post::find($postId);
            if ($voteType == 'up') {
                // update votes field in posts Table
                $postVotesDown = $post->votes_down;
                $postVotesDown = $postVotesDown - 1;
                $post->votes_down = $postVotesDown;
                $postVotesUp = $post->votes_up;
                $postVotesUp = $postVotesUp + 1;
                $post->votes_up = $postVotesUp;
                $result = $postVotesUp - $postVotesDown;
                $post->result = $result;
                $post->update();
                DB::table('votes')->where([
                    ['user_id', "=", $request['userId']],
                    ['post_id', "=", $request['postId']]
                ])->update(['vote_type' => $voteType]);
            }
            else {
                // update votes field in posts Table
                $postVotesUp = $post->votes_up;
                $postVotesUp = $postVotesUp - 1;
                $post->votes_up = $postVotesUp;
                $postVotesDown = $post->votes_down;
                $postVotesDown = $postVotesDown + 1;
                $post->votes_down = $postVotesDown;
                $result = $postVotesUp - $postVotesDown;
                $post->result = $result;
                $post->update();
                DB::table('votes')->where([
                    ['user_id', "=", $request['userId']],
                    ['post_id', "=", $request['postId']]
                ])->update(['vote_type' => $voteType]);
            }
            $result = $post->votes_up - $post->vote_down;
            $up = $post->votes_up;
            $down = $post->votes_down;
            return response()->json(['result' => $result, 'up' => $up, 'down' => $down], 200);
        }

    }
}

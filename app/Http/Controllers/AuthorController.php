<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreatePost;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:author');
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $posts = Post::Where('user_id', Auth::id())->pluck('id')->toarray();
        $allComments = Comment::whereIn('post_id', $posts)->get();
        $commentsToday = $allComments->where('created_at', '>=', Carbon::today());

        return view('author.dashboard', compact('allComments', 'commentsToday'));
    }

    public function posts()
    {
        return view('author.posts');
    }

    public function comments()
    {
        $posts = Post::where('user_id', Auth::id())->pluck('id')->toArray();
        $comments = Comment::whereIn('post_id', $posts)->get();
        return view('author.comments', compact('comments'));
    }

    public function newPost(){
        return view('author.newPost');
    }

    public function createPost(CreatePost $request)
    {
        $post = new Post();

        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->user_id = Auth::id();

        $post->save();
        return back()->with('success', 'Post is successfully created');
    }

    public function postEdit($id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::id())->first();
        return view('author.postEdit', compact('post'));
    }

    public function postEditPost(CreatePost $request, $id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::id())->first();
        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->save();

        return back()->with('success', "Post Updated Successfully");
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::id());
        if($post){
            $post->delete();
        }
        return redirect()->back()->with('success', "Post deleted successfully");
    }
}

<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
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

        $chart = new DashboardChart();
        $days = $this->generateDaysRange(Carbon::now()->subDays(30), Carbon::now());
        $postNumber = [];

        foreach ($days as $day){
            $postNumber[] = Post::whereDate('created_at', $day)->where('user_id', Auth::id())->count();
        }

        $chart->dataset('Posts', 'line', $postNumber);
        $chart->labels($days);
        return view('author.dashboard', compact('allComments', 'commentsToday', 'chart'));
    }

    private function generateDaysRange(Carbon $startDate, Carbon $endDate)
    {
        $dates = [];
        for($date=$startDate; $date->lte($endDate); $date->addDay()){
            $dates[] = $date->format('y-m-d');
        }
        return $dates;
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

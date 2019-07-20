<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use App\Comment;
use App\Http\Requests\CreatePost;
use App\Http\Requests\UserUpdate;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkRole:admin');
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $chart = new DashboardChart();
        $days = $this->generateDaysRange(Carbon::now()->subDays(30), Carbon::now());
        $postNumber = [];

        foreach ($days as $day){
            $postNumber[] = Post::whereDate('created_at', $day)->count();
        }

        $chart->dataset('Posts', 'line', $postNumber);
        $chart->labels($days);
        return view('admin.dashboard', compact('chart'));
    }

    private function generateDaysRange(Carbon $startDate, Carbon $endDate)
    {
        $dates = [];
        for($date=$startDate; $date->lte($endDate); $date->addDay()){
            $dates[] = $date->format('y-m-d');
        }
        return $dates;
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function userEdit($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.userEdit', compact('user'));
    }

    public function userEditPost(UserUpdate $request,$id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $request['name'];
        $user->email = $request['email'];
        if ($request['author'] == 1){
            $user->author = true;
        } else{
            $user->author = false;
        }

        if ($request['admin'] == 1){
            $user->admin = true;
        }else{
            $user->admin = false;
        }
        $user->save();
        return back()->with('success', 'User Updated Successfully');
    }

    public function userDelete($id){
        $user = User::where('id', $id)->first();
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

    public function posts()
    {
        $posts = Post::all();
        return view('admin.posts', compact('posts'));
    }

    public function postEdit($id)
    {
        $post = Post::where('id', $id)->first();
        return view('admin.postEdit', compact('post'));
    }

    public function postEditPost(CreatePost $request, $id)
    {
        $post = Post::where('id', $id)->first();
        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->save();
        return back()->with('success', 'Post Updated Successfully');
    }

    public function postDelete($id)
    {
        $post = Post::where('id', $id)->first();
        $post->delete();
        return back()->with('success', 'Post Delete Successfully');
    }

    public function comments()
    {
        $comments = Comment::all();
        return view('admin.comments', compact('comments'));
    }

    public function commentsDelete($id)
    {
        $comment = Comment::where('id', $id)->first();
        $comment->delete();
        return back()->with('success', 'Comment Deleted successfully');
    }
}

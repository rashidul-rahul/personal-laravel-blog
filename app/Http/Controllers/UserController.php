<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use App\Comment;
use App\Http\Requests\UserUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $chart = new DashboardChart;
        $days = $this->generateDateRange(Carbon::now()->subDays(30), Carbon::now());
        $comments = [];

        foreach ($days as $day){
            $comments[] = Comment::whereDate('created_at', $day)->where('user_id', Auth::id())->count();
        }

        $chart->dataset('Comments', 'line', $comments);
        $chart->labels($days);
        return view('user.dashboard', compact('chart'));
    }

    private function generateDateRange(Carbon $startDate, Carbon $endDate)
    {
        $dates = [];
        for($date = $startDate; $date->lte($endDate); $date->addDay()){
            $dates[] = $date->format('y-m-d');
        }

        return $dates;
    }

    public function comments()
    {
        return view('user.comments');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function commentPost($id)
    {
        $comment = Comment::where('id', $id)->where('user_id', Auth::id())->first();
        if ($comment){
            $comment->delete();
        }
        return back();
    }

    public function profilePost(UserUpdate $request)
    {
        $user = Auth::user();
       $user->name = $request['name'];
       $user->email = $request['email'];
       $user->save();

       if($request['password'] != ""){
           if(!(Hash::check($request['password'], Auth::user()->password))){
               return redirect()->back()->with('error', "Your provided password is not match with password");
           }

           if(strcmp($request['password'], $request['new_password'])==0){
               return redirect()->back()->with('error', 'New Password Cannot be same as old password');
           }

           $validation = $request->validate([
               'password' => 'required|string',
               'new_password' => 'required|string|min:6|confirmed',
           ]);

           $user->password = bcrypt($request['new_password']);
           $user->save();
           return redirect()->back()->with('success', 'Password Change Successful');
       }
       return back();
    }

    public function newComment(Request $request)
    {
        $comment = new Comment;

        $comment->user_id = Auth::id();
        $comment->post_id = $request['post_id'];
        $comment->content = $request['content'];

        $comment->save();
        return back();
    }
}

@extends('layouts.admin')

@section('title') Admin Comments @endsection

@section('content')
    <div class="content">
        <div class="">
            <div class="card">
                <div class="card-header bg-light">
                    Comments
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Post Title</th>
                                <th>Comment</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td class="text-nowrap"><a href="{{ route('singlePost', $comment->post_id) }}">{{ $comment->post->title }}</a></td>
                                    <td>{{ $comment->content }}</td>
                                    <td>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</td>
                                    <form id="deleteComment-{{ $comment->id }}" action="{{ route('adminCommentsDelete', $comment->id) }}" method="post">@csrf</form>
                                    <td>
                                        <button onclick="
                                            if(confirm('Are you sure Want to delete?')){
                                                document.getElementById('deleteComment-{{ $comment->id }}').submit();
                                            }
                                        " class="btn btn-danger">X</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

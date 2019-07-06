@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="">
            <div class="card">
                <div class="card-header bg-light">
                    Comments
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Update At</th>
                                <th>Created At</th>
                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(Auth::user()->posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</td>
                                    <td>{{ \carbon\Carbon::parse($post->created_at)->diffForHumans() }}</td>
                                    <td>{{ $post->comments->count() }}</td>
                                    <form id="deletePost-{{ $post->id }}" action="{{ route('deletePost', $post->id) }}" method="post">@csrf</form>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('postEdit', $post->id) }}">Edit</a>

                                        <a class="btn btn-danger" onclick="
                                            var result = confirm('are you sure want to delete?');
                                            if(result){
                                                document.getElementById('deletePost-{{ $post->id }}').submit();
                                            }
                                        " href="#">
                                            Delete
                                        </a>
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

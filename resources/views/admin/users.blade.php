@extends('layouts.admin')

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
                                <th>Name</th>
                                <th>Post</th>
                                <th>Comment</th>
                                <th>Update At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td class="text-nowrap">{{ $user->name }}</td>
                                    <td>{{ $user->posts->count() }}</td>
                                    <td>{{ $user->comments->count() }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}</td>
                                    <form id="userDelete-{{ $user->id }}" action="{{ route('userDelete', $user->id) }}" method="post">@csrf</form>
                                    <td>
                                        <a onclick="
                                            if (confirm('Are sure want to delete user {{ $user->name }}')){
                                            document.getElementById('userDelete-{{ $user->id }}').submit();
                                            }"
                                            href="#" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                                        <a href="{{ route('adminUsersEdit', $user->id) }}" class="btn btn-success">
                                            <span class="fa fa-edit"></span>
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

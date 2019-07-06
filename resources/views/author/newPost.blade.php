@extends('layouts.admin')

@section('title') Create Post @endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('createPost') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header bg-light">
                                Create Post
                            </div>
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if($errors->any())

                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="normal-input" class="form-control-label">Title</label>
                                            <input id="normal-input" name="title" class="form-control" placeholder="Post Title">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-8">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="textarea">Content</label>
                                            <textarea id="textarea" name="content" class="form-control" rows="6" placeholder="Post Content"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

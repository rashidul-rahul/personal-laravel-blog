@extends('layouts.admin')

@section('title') Edit User:{{ $user->name }} @endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header bg-light">
                                Editing User:{{ $user->name }}
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
                                            <label for="name" class="form-control-label">Name</label>
                                            <input id="name" name="name" class="form-control" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-8">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" name="email" class="form-control" rows="6"value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="check">Permission</label>
                                            <input class="form-check" type="checkbox" name="author" value=1 {{ $user->author==true ? 'checked':'' }}> Author <br>
                                            <input class="form-check" type="checkbox" name="admin" value=1 {{ $user->admin==true? 'checked':'' }}> Admin
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

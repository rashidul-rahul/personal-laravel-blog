@extends('layouts.master')

@section('content')
<!-- Page Header -->
<header class="masthead" style="background-image: url('{{ url('assets/img/post-bg.jpg') }}')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-heading">
                    <h1>{{ $post->title }}</h1>
                    <span class="meta">Posted by
              <a href="#">{{ $post->user->name }}</a>
              on {{ date_format($post->created_at, 'F d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                {!! nl2br($post->content) !!}

            </div>
        </div>
            <div class="comment">
                <hr>
                <h3>Comments</h3>
                <hr>
                @foreach($post->comments as $comment)
                <p>{{ $comment->content }}</p>
                <p><small>Commented by <a href="">{{ $comment->user->name }}</a> on {{ date_format($comment->created_at, 'F d, Y') }}</small></p>
                @endforeach
            </div>
    </div>
</article>

@endsection

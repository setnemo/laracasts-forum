@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card panel panel-default">
                    <article>
                    <div class="card-header"><h4>{{ $thread->title }}</h4></div>

                    <div class="card-body">

                                <div class="body">{{ $thread->body }}</div>
                    </div>
                    </article>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                @foreach($thread->replies as $replay)
                    @include('threads.replay')
                @endforeach
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
            @if(auth()->check())
                <form method="POST" action="{{ $thread->getPath() . '/replies' }}">
                    <div class="form-group">
                        {{ csrf_field() }}
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"></textarea>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>

            @else
                <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
            </div>
        </div>
    </div>
@endsection

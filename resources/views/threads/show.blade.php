@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-8 mt-3">
                <div class="card panel panel-default">
                    <article>
                    <div class="card-header"><h4>{{ $thread->title }}</h4></div>

                    <div class="card-body">

                                <div class="body">{{ $thread->body }}</div>
                    </div>
                    </article>
                </div>
                @foreach($replies as $reply)
                    @include('threads.replay')
                @endforeach

                <div class="mt-3">
                    {{ $replies->links() }}
                </div>

                @if(auth()->check())
                    <form method="POST" action="{{ $thread->getPath() . '/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group mt-3">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                    </form>

                @else
                    <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <div class="card panel panel-default">
                    <div class="card-body">
                        <div class="body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="/threads?by={{ $thread->creator->name }}">{{ $thread->creator->name }}</a>,
                                and currently has {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

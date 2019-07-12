@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <h4>
                                    <a href="{{ $thread->getPath() }}" class="thread-link">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                                <div class="body">{{ $thread->body }}</div>
                                <div class="accordion">
                                    <p class="mt-2">Posted {{ $thread->created_at->diffForHumans() }} by
                                        <a href="/threads?by={{ $thread->creator->name }}">
                                        {{ $thread->creator->name }}
                                    </a> in <a href="/threads/{{ $thread->channel->name }}">
                                        {{ $thread->channel->name }}
                                    </a> channel and currently
                                        has {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}</p>
                                </div>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

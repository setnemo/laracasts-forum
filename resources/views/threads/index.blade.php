@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3 col-md-offset-2">
                @forelse($threads as $thread)
                <div class="card mt-3">
                    <div class="card-header level">
                        <h3 class="flex">
                            <a href="{{ $thread->getPath() }}" class="thread-link">
                                {{ $thread->title }}
                            </a>
                        </h3>
                        <a href="{{ $thread->getPath() }}">
                            {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('replies', $thread->replies_count) }}
                        </a>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                        <hr>
                        <small>Posted in <a href="{{ route('channel', $thread->channel->slug) }}">{{ $thread->channel->name }}</a>
                         by <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                         {{ $thread->created_at->diffforHumans() }}</small>
                    </div>
                </div>
                @empty
                    <p>There are no relevant results at this time</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

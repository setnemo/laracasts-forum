@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-3 col-md-offset-2">
            <h4>{{ $profileUser->name }} <small>Since {{ $profileUser->created_at->diffForHumans() }}</small></h4>
            @forelse($threads as $thread)
            <div class="card mt-3">
                <div class="card-header level">
                    <h3 class="flex">
                        <a href="{{ $thread->getPath() }}" class="thread-link">
                            {{ $thread->title }}
                        </a>
                    </h3>
                    @can ('update', $thread)
                    <form action="{{ $thread->getPath() }}" method="POST" role="form">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-sm btn-link btn-danger">Delete thread</button>
                    </form>
                    @endcan
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                    <hr>
                    <small>Posted in <a href="{{ route('channel', $thread->channel->slug) }}">{{ $thread->channel->name }}</a>
                        by <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                        {{ $thread->created_at->diffforHumans() }}
                        and has {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('replies', $thread->replies_count) }}</small>
                </div>
            </div>
            @empty
                <p>There are no relevant results at this time</p>
            @endforelse
            <div class="mt-3">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection




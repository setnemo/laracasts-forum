@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>{{ $profileUser->name }} <small>Since {{ $profileUser->created_at->diffForHumans() }}</small></h4></div>

                <strong class="card-body">
                    @foreach($threads as $thread)
                        <article>
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $thread->getPath() }}" class="thread-link">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                                <a href="{{ $thread->getPath() }}">
                                    {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('replies', $thread->replies_count) }}
                                </a>
                            </div>
                            <div class="body">{{ $thread->body }}</div>

                        </article>
                        <div class="level">
                            <h4 class="flex">
                            </h4>
                            <small>Created at {{ $thread->created_at->diffForHumans() }}</small>
                        </div>
                        <hr>
                @endforeach
                <div class="mt-3">
                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

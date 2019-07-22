@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

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
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

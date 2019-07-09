@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                            <article>
                                <h4>{{ $thread->title }}</h4>
                                <div class="body">{{ $thread->body }}</div>
                            </article>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $replay)

                <div class="card">
                    <div class="card-body">
                        <h5>
                            {{ $replay->owner->name }} said
                            {{ $replay->created_at->diffForHumans() }}
                        </h5>
                        <div class="body">{{ $replay->body }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

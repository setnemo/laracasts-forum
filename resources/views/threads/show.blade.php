@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
            <div class="col-md-8">
                @foreach($thread->replies as $replay)
                    @include('threads.replay')
                @endforeach
            </div>
        </div>
    </div>
@endsection

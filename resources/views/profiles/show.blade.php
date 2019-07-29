@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-3 col-md-offset-2">
            <h4>{{ $profileUser->name }}</h4>
            @forelse($activities as $date => $activity)
                <h3>{{ $date }}</h3>
                @forelse ($activity as $record)
                    @include ("profiles.activities.{$record->type}", ['activity' => $record])
                @empty
                @endforelse
                <hr/>
            @empty
                <p>There are no relevant results at this time</p>
            @endforelse
        </div>
    </div>
</div>
</div>
@endsection




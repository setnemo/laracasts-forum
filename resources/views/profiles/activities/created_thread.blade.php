@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} published
        <a href="{{ $activity->subject->getPath() }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent

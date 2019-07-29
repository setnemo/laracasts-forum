@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied to
        <a href="{{ $activity->subject->thread->getPath() }}">"{{ $activity->subject->thread->title }}"</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent

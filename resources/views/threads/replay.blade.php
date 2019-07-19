<div class="card mt-3">
    <div class="card-body">
        <div class="level">
            <h5 class="flex" >
                <a href="/threads?by={{ $reply->owner->name }}">{{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }}
            </h5>
            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="POST" role="form">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary"{{ $reply->isFavorited() ? ' disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ \Illuminate\Support\Str::plural('favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
        <div class="body">
            {{ $reply->body }}
        </div>
    </div>
</div>

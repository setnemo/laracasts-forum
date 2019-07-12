<div class="card mt-3">
    <div class="card-body">
        <h5>
            <a href="/threads?by={{ $replay->owner->name }}">{{ $replay->owner->name }}</a> said
            {{ $replay->created_at->diffForHumans() }}
        </h5>
        <div class="body">{{ $replay->body }}</div>
    </div>
</div>

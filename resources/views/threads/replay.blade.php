<div class="card mt-3">
    <div class="card-body">
        <h5>
            {{ $replay->owner->name }} said
            {{ $replay->created_at->diffForHumans() }}
        </h5>
        <div class="body">{{ $replay->body }}</div>
    </div>
</div>

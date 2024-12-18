<div class="spacesFollow">
    <p class="content-body">
    	{{ $profileUser->username }} replied to 
    	<a href="{{ $activity->subjectable->thread->path() }}">"{{ $activity->subjectable->thread->title }}"</a>.</p>
    <hr>
    <p class="content-body">{{ $activity->subjectable->body }}</p>
</div>
<div class="spacesFollow">
    <p class="content-body">
    	{{ $profileUser->username }} published 
    	<a href="{{ $activity->subjectable->path() }}">"{{ $activity->subjectable->title }}"</a>.
    </p>
    <hr>
    <p class="content-body">{{ $activity->subjectable->body }}</p>
</div>
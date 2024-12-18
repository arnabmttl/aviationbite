<div class="spacesFollow">
    <p class="content-body">
    	<a href="{{ $activity->subjectable->favourited->path() }}">
    		{{ $profileUser->username }} favourited a reply
    	</a>
    </p>
    <hr>
    <p class="content-body">{{ $activity->subjectable->favourited->body }}</p>
</div>
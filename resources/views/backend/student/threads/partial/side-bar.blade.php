<div class="col-md-4 col-12">
    <form method="POST" action="{{ route('threads.search') }}" class="searchForm hide-m">
        @csrf
        <i class="fas fa-search"></i>
        <input type="search" name="search" placeholder="Search Topics" autocomplete="off">
    </form>
    <div class="ask hide-m">
        @auth
            <button> <a href="{{ route('threads.create') }}"> <i class="fas fa-plus"></i> Ask A Question </a> </button>
        @else
            <button> <a href="" data-bs-toggle="modal" data-bs-target="#loginModal"> <i class="fas fa-plus"></i> Ask A Question (Not Logged In) </a> </button>
        @endauth
    </div>
    <br>
    <div class="spacesFollow">
        <div class="head">
            <p class="title highlight">Spaces to Follow</p>
            <img src="{{ asset('frontend/images/chat-icon.png') }}">
        </div>
        <div class="chatsCont">
        @foreach ($channels as $channelToFollow)
            <div class="chat">
                <a href="{{ route('thread.channel.index', $channelToFollow->slug) }}">
                    <p>
                        {{ $channelToFollow->name }}
                    </p>
                </a>
                <div class="chatNum">
                    {{ $channelToFollow->threads->count() }}
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <br>
    @auth
    <div class="spacesFollow">
        <div class="head">
            <p class="title highlight">My Active Threads</p>
            <img src="{{ asset('frontend/images/chat-icon.png') }}">
        </div>
        <div class="chatsCont">
        @foreach ($myActiveThreads as $myActiveThread)
            <div class="thread">
                <a href="{{ route('thread.show', [$myActiveThread->channel->slug, $myActiveThread->id]) }}">
                    <p>{{ $myActiveThread->title }}</p>
                </a>
            </div>
        @endforeach
        </div>
    </div>
    @endauth
</div>
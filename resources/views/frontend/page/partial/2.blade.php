<!-- BEGIN: Our Forums -->
    <section class="forums mt-5">
        <div class="container">
            <div class="head">
                <div class="title">
                    <p>{{ $section->title }}</p>
                </div>
                <div class="desc">
                    {!! $section->description !!}
                </div>
            </div>
            <div class="forumContent mt-5">
            @foreach($latestSixThreads as $key => $threadForSection)
                <div class="forumCard">
                    <div>
                        <p class="cardNumber">#{{ $key + 1 }}</p>
                    </div>
                    <div>
                        <p class="cardTitle">{{ $threadForSection->title }}</p>
                        <p class="cardText">{{ substr($threadForSection->body, 0, 120) }}<a class="readMoreBtn" href="{{ $threadForSection->path() }}">Read More</a></p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted at {{ $threadForSection->created_at }} by
                                <a href="#"> {{ $threadForSection->creator->username }} </a> </p>
                            </div>
                            <div class="right
                                ">
                                <p>{{ $threadForSection->replies->count() }}<br><span><a href="{{ $threadForSection->path() }}">{{ Str::plural('Reply' , $threadForSection->replies->count()) }}</span></a></p>
                                <p>{{ $threadForSection->views }}<br><span>Views</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

                <a href="{{ $section->redirection_url }}" class="viewAllBtn">All Forums <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </section>
<!-- END: Our Forums -->
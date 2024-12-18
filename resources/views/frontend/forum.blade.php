@extends('layouts.frontend.app')

@section('title', 'Forum')

@section('content')

    <!-- BEGIN: Forum -->
    <section class="forumCont faqsTabsCont pt-5 pb-5 test bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12 hide-d">
                     <form class="searchForm">
                        <i class="fas fa-search"></i>
                        <input type="search" name="search" placeholder="Search Topics">
                    </form>
                    
                    <div class="ask">
                        <button><i class="fas fa-plus"></i> Ask A Question </button>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <p class="title">Our Forums</p>
                    <nav>
                        <ul class='tabs tabsSlider owl-carousel owl-theme'>
                            <div class="item">
                                <li class='active' data-tab-id='tab1'>All Topics</li>
                            </div>
                            <div class="item">
                                <li data-tab-id='tab2'>Subscribed</li>
                            </div>
                            <div class="item">
                                <li data-tab-id='tab3'>Trending</li>
                            </div>
                        </ul>
                    </nav>
                    <div class="">
                        <div class='content-section'>
                            <div id='tab1' class='content active'>
                                <div class="forumCardCont">
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id='tab2' class='content'>
                                <div class="forumCardCont">
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id='tab3' class='content'>
                                <div class="forumCardCont">
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="forumCard">
                                        <div>
                                            <p class="cardNumber highlight">#1</p>
                                        </div>
                                        <div>
                                            <p class="cardTitle highlight">What is Lorem Lpsum?</p>
                                            <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                                dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                                            <div class="cardFooter">
                                                <div class="left">
                                                    <i class="far fa-user-circle"></i>
                                                    <p>Posted 21 june 2021 by XYZ</p>
                                                    <p>Last Updated 12:20 22 june 2021</p>
                                                </div>
                                                <div class="right
                                ">
                                                    <img src="{{ asset('frontend/images/flag.svg') }}">
                                                    <p>25<br><span>Reply</span></p>
                                                    <p>2.5k<br><span>Views</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <form class="searchForm hide-m">
                        <i class="fas fa-search"></i>
                        <input type="search" name="search" placeholder="Search Topics">
                    </form>
                    
                    <div class="ask hide-m">
                        <button><i class="fas fa-plus"></i> Ask A Question </button>
                    </div>
                    <br>
                    <div class="spacesFollow">
                        <div class="head">
                            <p class="title highlight">Spaces to Follow</p>
                            <img src="{{ asset('frontend/images/chat-icon.png') }}">
                        </div>
                        <div class="chatsCont">
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                            <div class="chat">
                                <p>Lorem Lipsum</p>
                                <div class="chatNum">20</div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="spacesFollow">
                        <div class="head">
                            <p class="title highlight">My Active Threads</p>
                            <img src="{{ asset('frontend/images/chat-icon.png') }}">
                        </div>
                        <div class="chatsCont">
                            <div class="thread">
                                <p>What is Lorem Lipsume and what are its benefits?</p>
                            </div>
                            <div class="thread">
                                <p>What is Lorem Lipsume and what are its benefits?</p>
                            </div>
                            <div class="thread">
                                <p>What is Lorem Lipsume and what are its benefits?</p>
                            </div>
                            <div class="thread">
                                <p>What is Lorem Lipsume and what are its benefits?</p>
                            </div>
                            <div class="thread">
                                <p>What is Lorem Lipsume and what are its benefits?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Forum -->
@endsection

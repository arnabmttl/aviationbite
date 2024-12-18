<!-- BEGIN: About Us -->
    <section class="about mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="aboutImg">
                        <img src="{{ $section->image->path }}">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="aboutText">
                        <p class="title">{{ $section->title }}</p>
                        {!! $section->description !!}
                        <a href="{{ $section->redirection_url }}"><button class="btn btnBlue">Know More</button></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- END: About Us -->
<!-- BEGIN: Courses Carousel -->
<section class="popCourses mt-5">
    <div class="container">
        <div class="head mb-5">
            <div class="title">
                <p>{{ $section->title }}</p>
            </div>
            <div class="desc">
                {!! $section->description !!}
            </div>
        </div>
        <div class="popCoursesContent popCoursesSlider  owl-carousel owl-theme">
        @foreach ($section->sectionable->items as $index => $item)
            @switch ($item->collectable_type)
                @case ('App\Models\Course')
                    <div class="item">
                        <div class="coursesCard">
                            <p class="title">{{ $item->collectable->name }}</p>
                            <p>
                                @foreach ($item->collectable->topics as $topic)
                                    {{ $topic->name }}, 
                                @endforeach
                            </p>
                            {!! $item->collectable->short_description !!}
                            <div class="cardFooter">
                                <button class="btn">₹ {{ $item->collectable->price }}</button>
                                <a href="{{ route('single.course', $item->collectable->slug) }}">Course</a>
                            </div>
                        </div>
                    </div>
                @break
            @endswitch
        @endforeach</div><div class="popCoursesContent popCoursesSlider  owl-carousel owl-theme"><br></div><div class="popCoursesContent popCoursesSlider  owl-carousel owl-theme">
        </div>
    </div>
</section>
<!-- END: Popular Courses -->
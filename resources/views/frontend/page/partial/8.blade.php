<!-- BEGIN: Text Over Image Section -->
<section class="testimonial p-5" style="background: url({{ $section->image->path }})">
    <div class="container">
        <p class="title">{{ $section->title }}</p>
        <p class="desc">
        	{!! $section->description !!}
        </p>
    </div>
</section>
<!-- END: Text Over Image Section -->
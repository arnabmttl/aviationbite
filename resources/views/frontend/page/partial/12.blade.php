<!-- BEGIN: FAQ Section -->
<section class="faqs mt-5 mb-5">
    <div class="container">
        <div class="head mb-5">
            <div class="title">
                <p>{{ $section->title }}</p>
            </div>
            <div class="desc">
                {!! $section->description !!}
            </div>
        </div>
        <div class="accordion tabOneContent" id="tabOneContent">
        @foreach($section->sectionable->items as $index => $item)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $item->id . $item->collectable->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id . $item->collectable->id }}" aria-expanded="false">
                        {{ $item->collectable->question }}
                    </button>
                </h2>
                <div id="collapse{{ $item->id . $item->collectable->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        {!! $item->collectable->answer !!}
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</section>
<!-- END: FAQ Section -->
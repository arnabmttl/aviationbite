<div class="col-md-12">
    {!! 
        Form::model($section, [
            'method' => 'Post', 
            'action' => ['App\Http\Controllers\Backend\SectionsController@addFaq', $section->id], 
            'class' => 'form'
        ])
    !!}

    <div class="form-body">
        <div class="row">

            <!-- Question -->
            <div class="col-12 form-label-group">
                {!!
                    Form::text(
                        'faq_question',
                        null,
                        [
                            'id' => 'faq_question',
                            'class' => 'form-control '.($errors->has('faq_question') ? 'is-invalid':''),
                            'placeholder' => 'Question',
                            'aria-describedby' => 'faq_question',
                            'required' => true,
                            'tabindex' => '1'
                        ]
                    )
                !!}
                {!! Form::label('faq_question', 'Question') !!}

                @error('faq_question')
                    <x-validation-error-message :message="$message" />
                @enderror
            </div>

            <!-- Answer -->
            <div class="col-12 form-label-group">
                {!!
                    Form::textarea(
                        'faq_answer',
                        null,
                        [
                            'id' => 'faq_answer',
                            'class' => 'form-control '.($errors->has('faq_answer') ? 'is-invalid':''),
                            'placeholder' => 'Answer',
                            'aria-describedby' => 'faq_answer',
                            'required' => true,
                            'tabindex' => '1'
                        ]
                    )
                !!}
                {!! Form::label('faq_answer', 'Answer') !!}

                @error('faq_answer')
                    <x-validation-error-message :message="$message" />
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Add</button>
                <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ $cancelUrl }}">
                    Cancel
                </a>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
<!-- Hoverable rows start -->
@if ($section->sectionable)
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Q&A</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($section->sectionable->items as $index => $item)
                            <tr>
                                <td>
                                    <!-- FAQ Accordion start -->
                                    <section id="accordion-with-border">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="faqaccordian{{ $item->id }}" role="tablist" aria-multiselectable="true">
                                                    <div class="card collapse-icon">
                                                        <div class="card-body">
                                                            <div class="collapse-border" id="faqaccrd{{ $item->id }}">
                                                                <div class="card">
                                                                    <div class="card-header" id="heading{{ $item->id }}" data-toggle="collapse" role="button" data-target="#collapse{{ $item->id }}" aria-expanded="false" aria-controls="collapse{{ $item->id }}">
                                                                        <span class="lead collapse-title"> {{ $item->collectable->question }} </span>
                                                                    </div>

                                                                    <div id="collapse{{ $item->id }}" class="collapse" aria-labelledby="heading{{ $item->id }}" data-parent="#faqaccordian{{ $item->id }}">
                                                                        <div class="card-body">
                                                                            {!! $item->collectable->answer !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- FAQ Accordion end -->
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                        @if ($item->sort_order > 1)
                                            <a class="dropdown-item" href="{{ route('collection.item.move.up', [$section->id, $item->id]) }}">
                                                <i data-feather="arrow-up" class="mr-50"></i>
                                                <span>Move Up</span>
                                            </a>
                                        @endif
                                        @if ($item->sort_order < $item->collection->items->count())
                                            <a class="dropdown-item" href="{{ route('collection.item.move.down', [$section->id, $item->id]) }}">
                                                <i data-feather="arrow-down" class="mr-50"></i>
                                                <span>Move Down</span>
                                            </a>
                                        @endif
                                            <a 
                                                class="dropdown-item"
                                                href="{{ route('collection.item.destroy', [$section->id, $item->id]) }}"
                                                onclick="event.preventDefault();document.getElementById('item-delete-form-'+{{ $item->id }}).submit();"
                                            >
                                                <i data-feather="trash" class="mr-50"></i>
                                                <span>Delete</span>
                                            </a>
                                            <form id="item-delete-form-{{ $item->id }}" action="{{ route('collection.item.destroy', [$section->id, $item->id]) }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete" />
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- Hoverable rows end -->
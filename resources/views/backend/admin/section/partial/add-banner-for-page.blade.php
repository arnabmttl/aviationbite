<div class="col-md-12">
    {!! 
        Form::model($section, [
            'method' => 'Post', 
            'action' => ['App\Http\Controllers\Backend\SectionsController@addBannerForPage', $section->id], 
            'class' => 'form',
            'files' => true
        ])
    !!}

    <div class="form-body">
        <div class="row">

            <!-- Banner Text -->
            <div class="col-12 form-label-group">
                {!!
                    Form::textarea(
                        'banner_text',
                        null,
                        [
                            'id' => 'banner_text',
                            'class' => 'form-control '.($errors->has('banner_text') ? 'is-invalid':''),
                            'placeholder' => 'Banner Text',
                            'aria-describedby' => 'banner_text',
                            'tabindex' => '1'
                        ]
                    )
                !!}
                {!! Form::label('banner_text', 'Banner Text') !!}

                @error('banner_text')
                    <x-validation-error-message :message="$message" />
                @enderror
            </div>

            <!-- Banner Redirection URL -->
            <div class="col-12 form-label-group">
                {!!
                    Form::text(
                        'banner_redirection_url',
                        null,
                        [
                            'id' => 'banner_redirection_url',
                            'class' => 'form-control '.($errors->has('banner_redirection_url') ? 'is-invalid':''),
                            'placeholder' => 'Redirection URL',
                            'aria-describedby' => 'banner_redirection_url',
                            'tabindex' => '2'
                        ]
                    )
                !!}
                {!! Form::label('banner_redirection_url', 'Redirection URL') !!}

                @error('banner_redirection_url')
                    <x-validation-error-message :message="$message" />
                @enderror
            </div>

            <!-- Banner Button Text -->
            

            <!-- Desktop Image -->
            <div class="col-12">
                <fieldset class="form-group">
                    {!! Form::label('desktop_image', 'Desktop Image') !!}
                    <div class="custom-file">
                        {!! 
                            Form::file(
                              'desktop_image', 
                              [
                                'class' => 'custom-file-input',
                                'id' => 'desktop_image',
                                'accept'=>'image/*',
                                'required' => true,
                                'tabindex' => '4'
                              ]
                            )
                        !!}

                        <label class="custom-file-label" for="desktop_image">Choose file</label>
                    </div>
                </fieldset>

                @error('desktop_image')
                    <span class="help-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Mobile Image -->
            <div class="col-12">
                <fieldset class="form-group">
                    {!! Form::label('mobile_image', 'Mobile Image') !!}
                    <div class="custom-file">
                        {!! 
                            Form::file(
                              'mobile_image', 
                              [
                                'class' => 'custom-file-input',
                                'id' => 'mobile_image',
                                'accept'=>'image/*',
                                'required' => true,
                                'tabindex' => '5'
                              ]
                            )
                        !!}

                        <label class="custom-file-label" for="mobile_image">Choose file</label>
                    </div>
                </fieldset>

                @error('mobile_image')
                    <span class="help-block">
                        <strong>{{ $message }}</strong>
                    </span>
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
                                <th>Sort Order</th>
                                <th>Desktop Banner</th>
                                <th>Mobile Banner</th>
                                <th>Text</th>
                                <th>Redirection URL</th>
                                <th>Button Text</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($section->sectionable->items as $index => $item)
                            <tr>
                                <th scope="row">
                                    {{ $item->sort_order }}
                                </th>
                                <td>
                                    <img src="{{ asset('storage/'.$item->collectable->url) }}" height="100px">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/'.$item->collectable->image->url) }}" height="100px">
                                </td>
                                <td>
                                    {{ $item->collectable->image->text }}
                                </td>
                                <td>
                                    {{ $item->collectable->image->redirection_url }}
                                </td>
                                <td>
                                    {{ $item->collectable->image->button_text }}
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

@section('page-scripts')
    <script src="{{ asset('backend/js/summernote.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#banner_text').summernote();
        });
    </script>  
@endsection
<!-- BEGIN: HOME BANNER -->
							<section class="homeBanner" id="section-{{$section->id}}-custom-margin">
							    <div class="homeBannerSlider owl-carousel owl-theme" id="section-{{$section->id}}">
							        @foreach($section->sectionable->items as $index => $item)
							            <div class="item">
							                @if($item->collectable->redirection_url)
							                    <a href="{{$item->collectable->redirection_url}}">
							                        <div class="banner1-bg" style="background-image: url({{ $item->collectable->path }})">
							                            <div class="container">
							                                    {!! $item->collectable->text !!}            
							                            </div>
							                        </div>
							                    </a>
							                @else
							                    <div class="banner1-bg" style="background-image: url({{ $item->collectable->path }})">
							                        <div class="container">
							                                {!! $item->collectable->text !!}            
							                        </div>
							                    </div>
							                @endif
							            </div>
							        @endforeach
							    </div>
							</section>
							<!-- END: HOME BANNER -->
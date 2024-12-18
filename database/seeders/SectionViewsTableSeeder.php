<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\SectionViewRepository;

class SectionViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/**
         * Check if any section view(s) exist or not.
         * If no section view exists then only create section view(s).
         */
        $sectionViewRepository = new SectionViewRepository;
        $numberOfSectionViews = $sectionViewRepository->getTotalSectionViews();

        if($numberOfSectionViews == 0) {
        	$sectionViewRepository->createSectionView([
        		'type' => 1,
        		'name' => 'Banner',
        		'content' => '<!-- BEGIN: HOME BANNER -->
							<section class="homeBanner" id="section-{{$section->id}}-custom-margin">
							    <div class="homeBannerSlider owl-carousel owl-theme" id="section-{{$section->id}}">
							        @foreach($section-&gt;sectionable-&gt;items as $index =&gt; $item)
							            <div class="item">
							                @if($item-&gt;collectable-&gt;redirection_url)
							                    <a href="{{$item->collectable->redirection_url}}">
							                        <div class="banner1-bg" style="background-image: url({{ $item->collectable->path }})">
							                            <div class="container">
							                                    {!! $item-&gt;collectable-&gt;text !!}            
							                            </div>
							                        </div>
							                    </a>
							                @else
							                    <div class="banner1-bg" style="background-image: url({{ $item->collectable->path }})">
							                        <div class="container">
							                                {!! $item-&gt;collectable-&gt;text !!}            
							                        </div>
							                    </div>
							                @endif
							            </div>
							        @endforeach
							    </div>
							</section>
							<!-- END: HOME BANNER -->'
			]);
		}

		$numberOfSectionViews = $sectionViewRepository->getTotalSectionViews();

        if($numberOfSectionViews == 1) {
        	$sectionViewRepository->createSectionView([
        		'type' => 2,
        		'name' => 'Our Forums',
        		'content' => '<!-- BEGIN: Our Forums -->
							    <section class="forums mt-5">
							        <div class="container">
							            <div class="head">
							                <div class="title">
							                    <p>{{ $section-&gt;title }}</p>
							                </div>
							                <div class="desc">
							                    {!! $section-&gt;description !!}
							                </div>
							            </div>
							            <div class="forumContent mt-5">
							            @foreach($latestSixThreads as $key =&gt; $threadForSection)
							                <div class="forumCard">
							                    <div>
							                        <p class="cardNumber">#{{ $key + 1 }}</p>
							                    </div>
							                    <div>
							                        <p class="cardTitle">{{ $threadForSection-&gt;title }}</p>
							                        <p class="cardText">{{ $threadForSection-&gt;body }}<a class="readMoreBtn" href="{{ $threadForSection->path() }}">Read More</a></p>
							                        <div class="cardFooter">
							                            <div class="left">
							                                <p>Posted 21 june 2021 by XYZ</p>
							                                <p>Last Updated 12:20 22 june 2021</p>
							                            </div>
							                            <div class="right
							                                ">
							                                <p>25<br><span>Reply</span></p>
							                                <p>2.5k<br><span>Views</span></p>
							                            </div>
							                        </div>
							                    </div>
							                </div>
							            @endforeach

							                <a href="{{ $section->redirection_url }}" class="viewAllBtn">All Forums <i class="fas fa-angle-right"></i></a>
							            </div>
							        </div>
							    </section>
							<!-- END: Our Forums -->'
			]);
		}

		$numberOfSectionViews = $sectionViewRepository->getTotalSectionViews();

        if($numberOfSectionViews == 2) {
        	$sectionViewRepository->createSectionView([
        		'type' => 3,
        		'name' => 'Text with Image on Left',
        		'content' => '<!-- BEGIN: Text with Image on Left -->
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
							                        <p class="title">{{ $section-&gt;title }}</p>
							                        {!! $section-&gt;description !!}
							                        <a href="{{ $section->redirection_url }}"><button class="btn btnBlue">Know More</button></a>
							                    </div>
							                </div>
							            </div>
							        </div>
							    </section>
							<!-- END: Text with Image on Left -->'
			]);
		}

		$numberOfSectionViews = $sectionViewRepository->getTotalSectionViews();

        if($numberOfSectionViews == 3) {
        	$sectionViewRepository->createSectionView([
        		'type' => 6,
        		'name' => 'Text with Image on Right',
        		'content' => '<!-- BEGIN: Text with Image on Right -->
							    <section class="about testSeries mt-5">
							        <div class="container">
							            <div class="row">
							                <div class="col-lg-6 col-12">
							                    <div class="aboutText">
							                        <p class="title">{{ $section-&gt;title }}</p>
							                        {!! $section-&gt;description !!}
							                        <a href="{{ $section->redirection_url }}"><button class="btn btnBlue">Know More</button></a>
							                    </div>
							                </div>
							                <div class="col-lg-6 col-12">
							                    <div class="aboutImg">
							                        <img src="{{ $section->image->path }}">
							                    </div>
							                </div>
							            </div>
							        </div>
							    </section>
							    <!-- END: Text with Image on Right -->'
			]);
		}
    }
}

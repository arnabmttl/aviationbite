<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\FooterRepository;

class FootersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any footer exist or not.
         * If no footer exists then only create footer.
         */
        $footerRepostiory = new FooterRepository;
        $numberOfFooters = $footerRepostiory->getTotalFooters();

        if($numberOfFooters == 0) {
        	$footerRepostiory->createFooter([
        		'description' => '<footer class="footer pt-5 pb-5">
								    <div class="container">
								        <div class="row">
								            <div class="col-md-3 col-12">
								                <div class="footerLogo">
								                    <img src="'.asset('frontend/images/logo.svg').'">
								                </div>
								                <p class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
								                <div class="socialIcons">
								                    <a href=""><i class="fab fa-facebook-f"></i></a>
								                    <a href=""><i class="fab fa-twitter"></i></a>
								                    <a href=""><i class="fab fa-linkedin"></i></a>
								                    <a href=""><i class="fab fa-instagram"></i></a>
								                </div>
								            </div>
								            <div class="col-md-3 col-12">
								                <p class="title">My Account</p>
								                <div class="links">
								                    <a href="">Login</a>
								                    <a href="">My Account</a>
								                    <a href="">My Courses</a>
								                </div>
								            </div>
								            <div class="col-md-3 col-12">
								                <p class="title">Legal</p>
								                <div class="links">
								                    <a href="">Contact Us</a>
								                    <a href="">Privacy policy</a>
								                    <a href="">Terms & Conditions</a>
								                </div>
								            </div>
								            <div class="col-md-3 col-12 newsletter">
								                <p class="title">Newsletter</p>
								                <p>Subscribe to discounts & offers</p>
								                <form class="subscriptionForm">
								                    <input type="email" name="email" placeholder="Email address">
								                    <button class="btn">Subscribe</button>
								                </form>
								            </div>
								        </div>
								    </div>
								</footer>'
        	]);
        }
    }
}

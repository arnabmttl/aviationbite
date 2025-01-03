<!-- BEGIN: Footer-->
{{-- {!! $footer ? $footer->description : '' !!} --}}
<!-- END: Footer-->
<footer class="footer pt-5 pb-5">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-12">
				<div class="footerLogo"><br>
					<img src="https://aviationbite.com/frontend/images/logo.png" class="note-float-left" style="float: left;">
				</div>
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
                    @auth
                        <a href="{{ route('dashboard') }}">My Account</a>
                        <a href="{{ route('dashboard') }}">My Courses</a>
                    @else                    
                        <a href="" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    @endauth
				</div>
			</div>
			<div class="col-md-3 col-12">
				<p class="title">Legal</p>
				<div class="links">
					<a href="https://aviationbite.com/contact-us">Contact Us</a>
					<a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
					<a href="{{ route('terms') }}" target="_blank">Terms &amp; Conditions</a>
				</div>
			</div>
			<form class="col-md-3 col-12 newsletter" method="POST" action="{{ route('save-newsletter') }}">
				@csrf
				<p class="title">Newsletter</p>
				<p>Subscribe to discounts &amp; offers</p>
				<input type="email" name="email_id" placeholder="Email address" required autocomplete="off">
				<input type="hidden" name="current_route_name" value="{{ \Request::url() }}">
				<button class="btn" type="submit">Subscribe</button>
			</form>
		</div>
	</div>
</footer>
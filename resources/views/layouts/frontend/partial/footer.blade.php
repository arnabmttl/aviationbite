<!-- BEGIN: Footer-->
{{-- {!! $footer ? $footer->description : '' !!} --}}
<!-- END: Footer-->
<footer class="footer pt-5 pb-5" id="footer-footer">
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
					<a href="{{ route('contact.us') }}">Contact Us</a>
					<a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
					<a href="{{ route('terms') }}" target="_blank">Terms &amp; Conditions</a>
				</div>
			</div>
			<form class="col-md-3 col-12 newsletter" v-on:submit="saveNewsletter">
				<input type="email" required autocomplete="off" v-model="email_id" placeholder="Email address" >
				<button class="btn" type="submit">Subscribe</button>
			</form>
		</div>
	</div>

	<script>
		new Vue({
            el: "#footer-footer",            
            data: {                
                email_id: null,                
            },
            methods: {
                
                saveNewsletter(e) {
                    // alert(this.email_id);
					e.preventDefault()

					axios.post(
                        "{{ route('save-newsletter') }}", 
                    {
                        'email_id': this.email_id
                    }).then((response) => {
						console.log(response.data.result)
                        if (response.data.result) {
							toastr.success(this.email_id+' Subscribe Successfully For Newsletter');
							this.email_id = null;
                        } else {
							toastr.info(this.email_id+' already subscribed');
						}
                    }).catch((error) => {                        
						toastr.info('There is some problem for subscribing.');
                    });

					

					
                }
            },

        });
	</script>
</footer>
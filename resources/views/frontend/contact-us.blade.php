@extends('layouts.frontend.app')

@section('title', 'Contact Us')

@section('content')
    <!-- BEGIN: Contact Us Banner -->
    @forelse ($banners as $banner)
    <section class="contact-page-banner" style="background-image: url({{ $banner->image }});">
        <div class="container">
            <div class="row">
                <div class="col-12 contact-banner-text">
                    <h2>Contact Us</h2>
                    <p>{{$banner->description}}</p>
                </div>
            </div>
        </div>
    </section>
    @empty
                
    @endforelse
    <!-- END: Contact Us Banner -->

    <!-- BEGIN: Contact Us Main -->
    <section class="main-contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="git-title">Get in Touch</h2>
                    <h2 class="git-subtitle">Using One Of The Options Below</h2>
                </div>
            </div>
            <div class="row contact-info">
                {{-- <div class="col-lg-5">
                    <div class="row">
                        <div class="col-2 text-end">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="col-10 contact-location-text">
                            <h5>Address</h5>
                            <p>Lorem Lipsusum<br>
                                andheri nadi<br>
                                1100000
                            </p>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-2 text-end">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="col-10 contact-location-text">
                            <h5>Phone</h5>
                            <p><a href="tel:+919050566448">+91 90505 66448</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-2 text-end">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="col-10 contact-location-text">
                            <h5>Mail Address</h5>
                            <p><a href="mailto:support@aviationbite.com">support@aviationbite.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('enquiry') }}" method="POST">
                @csrf
                <div class="row contactForm">
                    <div class="col-lg-6">
                        <label for="name" class="contact-label">Your Name</label>
                        <input type="text" name="name" id="" class="form-control contact-name" placeholder="Enter your name here" autocomplete="off" maxlength="100" value="{{ old('name') }}">
                        @if($errors->has('name'))
                            <div class="error">{{ $errors->first('name') }}</div>
                        @endif

                        <label for="phone" class="contact-label">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control " placeholder="Enter phone number here" autocomplete="off" value="{{ old('phone_number') }}" maxlength="10">
                        @if($errors->has('phone_number'))
                            <div class="error">{{ $errors->first('phone_number') }}</div>
                        @endif

                        <label for="email" class="contact-label">Mail Id</label>
                        <input type="text" name="email" id="" value="{{ old('email') }}" class="form-control contact-email" placeholder="Enter email id here" autocomplete="off" maxlength="100">
                        @if($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                        @endif

                        <button type="submit" class="send-message"> Contact Us <span><i class="fas fa-long-arrow-alt-right"></i></span> </button>
                    </div>
                    <div class="col-lg-6">
                        <label for="message" class="contact-label">Message</label>
                        <textarea name="message" id="" class="form-control contact-textarea" placeholder="Type Message here">{{ old('message') }}</textarea>
                        @if($errors->has('message'))
                            <div class="error">{{ $errors->first('message') }}</div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        const phoneInput = document.getElementById('phone_number');

            // Add input event listener to allow only numbers
            phoneInput.addEventListener('input', function(event) {
            // Replace any non-digit characters with an empty string
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    </script>
    <!-- END: Contact Us Main -->
@endsection
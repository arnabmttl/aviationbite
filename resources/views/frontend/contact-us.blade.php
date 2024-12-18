@extends('layouts.frontend.app')

@section('title', 'Contact Us')

@section('content')
    <!-- BEGIN: Contact Us Banner -->
    <section class="contact-page-banner">
        <div class="container">
            <div class="row">
                <div class="col-12 contact-banner-text">
                    <h2>Contact Us</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and industry.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Contact Us Banner -->

    <!-- BEGIN: Contact Us Main -->
    <section class="main-contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="git-title">Get in Touchh</h2>
                    <h2 class="git-subtitle">Using One Of The Options Below</h2>
                </div>
            </div>
            <div class="row contact-info">
                <div class="col-lg-5">
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
                </div>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-2 text-end">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="col-10 contact-location-text">
                            <h5>Phone</h5>
                            <p>1.844.235.3567</p>
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
                            <p>support@genestring.co.in</p>
                        </div>
                    </div>
                </div>
            </div>
            <form action="">
                <div class="row contactForm">
                    <div class="col-lg-6">
                        <label for="name" class="contact-label">Your Name</label>
                        <input type="text" name="name" id="" class="form-control contact-name" placeholder="Enter your name here">
                        <label for="phone" class="contact-label">Phone Number</label>
                        <br>
                        <select class="contact-select form-control">
                            <option>+91</option>
                            <option>+81</option>
                            <option>+71</option>
                            <option>+61</option>
                        </select>
                        <input type="tel" name="phone" id="" class="form-control contact-phone" placeholder="Enter phone number here">
                        <label for="email" class="contact-label">Mail Id</label>
                        <input type="email" name="email" id="" class="form-control contact-email" placeholder="Enter email id here">
                        <a href="#" class="send-message"> Contact Us <span><i class="fas fa-long-arrow-alt-right"></i></span> </a>
                    </div>
                    <div class="col-lg-6">
                        <label for="message" class="contact-label">Message</label>
                        <textarea name="message" id="" class="form-control contact-textarea" placeholder="Type Message here"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- END: Contact Us Main -->
@endsection
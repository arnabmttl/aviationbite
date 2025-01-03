@extends('layouts.app')
 
@section('title', 'Register - LMS')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <div class="auth-wrapper auth-v2">
            <div class="auth-inner row m-0">
                <!-- Brand logo--><a class="brand-logo" href="javascript:void(0);">
                    <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                        <defs>
                            <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                <stop stop-color="#000000" offset="0%"></stop>
                                <stop stop-color="#FFFFFF" offset="100%"></stop>
                            </lineargradient>
                            <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                <stop stop-color="#FFFFFF" offset="100%"></stop>
                            </lineargradient>
                        </defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                <g id="Group" transform="translate(400.000000, 178.000000)">
                                    <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                    <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                    <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                    <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                    <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <h2 class="brand-text text-primary ml-1">LMS</h2>
                </a>
                <!-- /Brand logo-->
                <!-- Left Text-->
                <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                    <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{ asset('backend/app-assets/images/pages/register-v2.svg') }}" alt="Register V2" /></div>
                </div>
                <!-- /Left Text-->
                <!-- Register-->
                <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <h2 class="card-title font-weight-bold mb-1">Adventure starts here 🚀</h2>
                        <p class="card-text mb-2">Make your app management easy and fun!</p>
                        <form
                            id="cbz-login"
                            class="auth-register-form mt-2"
                            method="POST"
                            action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <x-label for="username" :value="__('Username')" />

                                <x-input 
                                    class="{{ $errors->has('username') ? 'is-invalid' : '' }}"
                                    id="username"
                                    type="text"
                                    name="username"
                                    placeholder="Username"
                                    :value="old('username')"
                                    aria-describedby="username"
                                    tabindex="1"
                                    required
                                    v-model="username"
                                    v-on:input="checkUsername"
                                    autofocus />

                                <span v-if="sign_up_errors.username" class="error">
                                    <strong v-text="sign_up_errors.username"></strong>
                                </span>

                                @error('username')
                                    <x-validation-error-message :message="$message" />
                                @enderror
                            </div>

                            <div class="form-group">
                                <x-label for="name" :value="__('Name')" />

                                <x-input 
                                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    id="name"
                                    type="text"
                                    name="name"
                                    placeholder="John Doe"
                                    :value="old('name')"
                                    aria-describedby="name"
                                    tabindex="2"
                                    required
                                    autofocus />

                                @error('name')
                                    <x-validation-error-message :message="$message" />
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="phone_number" :value="__('Phone Number')" />

                                <x-input 
                                    class="{{ $errors->has('phone_number') ? 'is-invalid' : '' }}"
                                    id="phone_number"
                                    type="text"
                                    name="phone_number"
                                    placeholder="9999999999"
                                    :value="old('phone_number')"
                                    minlength="10"
                                    maxlength="10"
                                    pattern="[6-9]{1}[0-9]{9}"
                                    aria-describedby="phone_number"
                                    tabindex="3"
                                    required
                                    v-model="phone_number"
                                    v-on:input="checkPhoneNumber"
                                    autofocus />

                                <span v-if="sign_up_errors.phone_number" class="error">
                                    <strong v-text="sign_up_errors.phone_number"></strong>
                                </span>

                                @error('phone_number')
                                    <x-validation-error-message :message="$message" />
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="email" :value="__('Email')" />

                                <x-input 
                                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    id="email"
                                    type="email"
                                    name="email"
                                    placeholder="john@example.com"
                                    :value="old('email')"
                                    aria-describedby="email"
                                    tabindex="4"
                                    required
                                    v-model="email"
                                    v-on:input="checkEmail"
                                    autofocus />

                                <span v-if="sign_up_errors.email" class="error">
                                    <strong v-text="sign_up_errors.email"></strong>
                                </span>

                                @error('email')
                                    <x-validation-error-message :message="$message" />
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="password" :value="__('Password')" />

                                <div class="input-group input-group-merge form-password-toggle">
                                    <x-input 
                                        class="form-control-merge {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="············"
                                        aria-describedby="password"
                                        tabindex="5"
                                        required />

                                    <div class="input-group-append">
                                        <span class="input-group-text cursor-pointer">
                                            <i data-feather="eye"></i>
                                        </span>
                                    </div>

                                    @error('password')
                                        <x-validation-error-message :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                <div class="input-group input-group-merge form-password-toggle">
                                    <x-input 
                                        class="form-control-merge {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        placeholder="············"
                                        aria-describedby="password_confirmation"
                                        tabindex="6"
                                        required />

                                    <div class="input-group-append">
                                        <span class="input-group-text cursor-pointer">
                                            <i data-feather="eye"></i>
                                        </span>
                                    </div>

                                    @error('password_confirmation')
                                        <x-validation-error-message :message="$message" />
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="register-privacy-policy" type="checkbox" required tabindex="7" />
                                    <label class="custom-control-label" for="register-privacy-policy">I agree to<a href="javascript:void(0);">&nbsp;privacy policy & terms</a></label>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block" tabindex="8">Sign up</button>
                        </form>
                        <p class="text-center mt-2"><span>Already have an account?</span><a href="{{ route('login') }}"><span>&nbsp;Sign in instead</span></a></p>
                    </div>
                </div>
                <!-- /Register-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script>
    new Vue({
        el: "#cbz-login",
        
        data: {
            username: null,
            phone_number: null,
            email: null,

            sign_up_errors: {
                username: null,
                phone_number: null,
                email: null
            }
        },

        methods: {
            checkUsername() {
                axios.post(
                    '{{env('APP_URL')}}api/check-username', 
                    {
                        'username': this.username
                    }).then((response) => {
                        if (response.data.result) {
                            this.sign_up_errors.username = null
                        } else {
                            this.sign_up_errors.username = 'Provided username is invalid.'
                        }
                    }).catch((error) => {
                        if (error.response.status == 422) {
                            this.sign_up_errors.username = error.response.data.errors.username;
                        }
                    });
            },

            checkPhoneNumber() {
                axios.post(
                    '{{env('APP_URL')}}api/check-phone-number', 
                    {
                        'phone_number': this.phone_number
                    }).then((response) => {
                        if (response.data.result) {
                            this.sign_up_errors.phone_number = null
                        } else {
                            this.sign_up_errors.phone_number = 'Provided phone number is invalid.'
                        }
                    }).catch((error) => {
                        if (error.response.status == 422) {
                            this.sign_up_errors.phone_number = error.response.data.errors.phone_number;
                        }
                    });
            },

            checkEmail() {
                axios.post(
                    '{{env('APP_URL')}}api/check-email', 
                    {
                        'email': this.email
                    }).then((response) => {
                        if (response.data.result) {
                            this.sign_up_errors.email = null
                        } else {
                            this.sign_up_errors.email = 'Provided Email is invalid.'
                        }
                    }).catch((error) => {
                        if (error.response.status == 422) {
                            this.sign_up_errors.email = error.response.data.errors.email;
                        }
                    });
            }
        }
    });
</script>
@endsection
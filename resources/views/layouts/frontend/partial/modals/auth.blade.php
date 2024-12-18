<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="padding: 25px;text-align: left;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
            <div id="cbz-login">
                <div id="cbz-login-form">
                    <p class="title">Login to your Account</p>
                    <p class="desc">Enter to continue and explore within your grasp</p>
                    <div class="numberCont">
                        <div class="form-group">
                            <label class="wrap">
                                <select class="form-control" id="selectNumber">
                                    <option>+91</option>
                                </select>
                            </label>
                        </div>
                        <input class="formControl" type="tel" name="number" v-model="phone" placeholder="Enter Number" pattern="^[0]?[6789]\d{9}$" title="Please enter a correct phone number" id="number" required autocomplete="off">
                    </div>
                    <div class="form-check login-rem">
                        <div v-if="message.success" class="text-success" align="center">
                            <p v-text="message.success" class="text-success"></p>
                        </div>
                        <div v-if="message.failure" align="center" class="text-danger">
                            <p v-text="message.failure" class="text-danger"></p>
                        </div>

                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button v-on:click="checkNumber(phone)">Continue to Log-In</button>
                </div>
                <div id="cbz-otp-form" style="display: none;">
                    <p class="title">Enter OTP</p>
                    <p class="desc">We have sent a 4 digit OTP to your no <span id="numberEntered">+91-@{{ phone }}</span> <a v-on:click="changeNumber()"><i class="fas fa-pen-square"></i></a></p>
                    <div>
                        <span>OTP is @{{ otpReceived }}</span>
                    </div>
                    <div class="otpCont">
                        <div class="otpContent">
                        <input id="codeBox1" class="formControl otp" type="tel" name="otp" placeholder="0" oninput='digitValidate(this)' onkeyup='tabChange(1)'maxlength="1" required  v-model="otp[0]" autofocus>
                        <input id="codeBox2" oninput='digitValidate(this)' onkeyup='tabChange(2)'  class="formControl otp" type="tel" name="otp" placeholder="0" maxlength="1" required  v-model="otp[1]">
                        <input id="codeBox3" oninput='digitValidate(this)' onkeyup='tabChange(3)' class="formControl otp" type="tel" name="otp" placeholder="0" maxlength="1" required  v-model="otp[2]">
                        <input id="codeBox4" oninput='digitValidate(this)'onkeyup='tabChange(4)' class="formControl otp" type="tel" name="otp" placeholder="0" maxlength="1" required  v-model="otp[3]">
                        </div>
                        <div class="">
                            <button class="btn btn-success" v-if="otp.length == 4" v-on:click="verifyOTP(phone, otp)">Verify</button>
                        </div>
                    </div>
                    <div class="otpCont">
                        <div v-if="message.success" class="text-success" align="center">
                            <p v-text="message.success" class="text-success"></p>
                        </div>
                        <div v-if="message.failure" align="center" class="text-danger">
                            <p v-text="message.failure" class="text-danger"></p>
                        </div>
                    </div>

                    <div class="popupFooter">
                        <div class="content">
                            <p class="desc">You can resend the code in</p>
                            <p class="highlight">@{{ time | prettify }}</p>
                        </div>
                        <div>
                            <button v-on:click="checkNumber(phone)" :disabled="time != 0">Resend OTP</button>
                        </div>
                    </div>
                </div>
                <div id="cbz-create-user-form" style="display: none;">
                    <p class="title">Coming for the first time</p>
                    <p class="desc">Enter your details</p>
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content auth-register-form mt-2">
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
                                    v-model="name"
                                    tabindex="2"
                                    required
                                    autofocus />

                                <span v-if="sign_up_errors.name" class="error">
                                    <strong v-text="sign_up_errors.name"></strong>
                                </span>

                                @error('name')
                                    <x-validation-error-message :message="$message" />
                                @enderror
                            </div>
                            <div class="form-group">
                                <x-label for="phone_number" :value="__('Phone Number')" />

                                <input 
                                    class="{{ $errors->has('phone_number') ? 'is-invalid' : '' }} form-control"
                                    id="phone_number"
                                    type="text"
                                    name="phone_number"
                                    placeholder="9999999999"
                                    :value="phone"
                                    minlength="10"
                                    maxlength="10"
                                    pattern="[6-9]{1}[0-9]{9}"
                                    aria-describedby="phone_number"
                                    tabindex="3"
                                    required
                                    readonly
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
                        </div>
                    </div>
                    <div class="form-check mt-1">
                        <div v-if="message.success" class="text-success" align="center">
                            <p v-text="message.success" class="text-success"></p>
                        </div>
                        <div v-if="message.failure" align="center" class="text-danger">
                            <p v-text="message.failure" class="text-danger"></p>
                        </div>
                    </div>
                    <button v-on:click="createSelf($event)">Continue to Log-In</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
    new Vue({
        el: "#cbz-login",
        
        data: {
            phone: "",
            otp: [],
            time: 30,
            isFirstLogin: false,
            image: null,
            username: null,
            name: null,
            email: null,
            otpReceived: null,
            sign_up_errors: {
                username: null,
                name: null,
                email: null
            },
            message: {
                success: '',
                failure: ''
            }
        },

        filters: {
            prettify : function(value) {
                if (value < 10) {
                    value = "0"+value
                }

                return "00:"+value
             }
        },

        methods: {
            checkNumber(phone) {
                this.time = 30

                axios.post(
                    '{{env('APP_URL')}}api/send-otp', 
                    {
                        'phone_number': phone
                    }).then((response) => {
                        if (response.data.result) {
                            if (response.data.is_blocked == 1) {
                                this.message.success = '';
                                this.message.failure = 'Your account has been blocked please contact admin';
                            } else {
                                console.log('Otp is ' + response.data.otp);
                                this.otpReceived = response.data.otp;
                                
                                document.getElementById('cbz-login-form').style.display = 'none';
                                document.getElementById('cbz-otp-form').style.display = 'block';

                                this.message.success = 'OTP sent successfully to your mobile number.';
                                this.message.failure = '';
                                this.isFirstLogin = response.data.is_first_login;

                                setInterval( () => {
                                    if (this.time > 0) {
                                        this.time--
                                    } else {
                                        clearInterval(this.timer)
                                    }
                                }, 1000)
                            }
                        } else {
                            this.message.success = '';
                            this.message.failure = 'There is some problem with the server. Kindly try again later.';
                        }
                    }).catch((error) => {
                        this.message.success = '';
                        this.message.failure = 'There is some problem with the server. Kindly try again later.';
                    });
            },

            verifyOTP: function(phone, otp) {
                axios.post(
                    '{{env('APP_URL')}}api/verify-otp', 
                {
                    'phone_number': phone,
                    'otp': otp.join('')
                }).then((response) => {
                    if (response.data.result) {
                        if (this.isFirstLogin) {
                            this.message.success = '';
                            this.message.failure = '';

                            document.getElementById('cbz-otp-form').style.display = 'none';
                            document.getElementById('cbz-create-user-form').style.display = 'block';
                        } else {
                            this.message.success = 'Successfully verified. Please wait you are being redirected.';
                            this.message.failure = '';

                            window.location.href = response.data.redirectTo;
                        }
                    } else {
                        this.message.failure = 'The OTP doesn\'t match or has expired. Kindly try again.';
                        this.message.success = '';
                    }
                }).catch((error) => {
                    this.message.failure = 'The OTP doesn\'t match. Kindly try again.';
                    this.message.success = '';
                });
            },

            changeNumber: function() {
                this.message.success = '';
                this.message.failure = '';

                document.getElementById('cbz-otp-form').style.display = 'none';
                document.getElementById('cbz-login-form').style.display = 'block';
            },

            onImageChange(e){
                this.image = e.target.files[0];
            },

            createSelf(event) {
                event.preventDefault();
                this.sign_up_errors.username = null
                this.sign_up_errors.name = null
                this.sign_up_errors.email = null

                if (!this.username)
                    this.sign_up_errors.username = 'Username is required'

                if (!this.name)
                    this.sign_up_errors.name = 'Name is required'

                if (!this.email)
                    this.sign_up_errors.email = 'Email is required'

                if (this.username && this.name && this.email) {
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
     
                    let formData = new FormData();
                    formData.append('username', this.username);
                    formData.append('name', this.name);
                    formData.append('email', this.email);
                    formData.append('phone_number', this.phone);
                    
                    axios.post(
                        '{{env('APP_URL')}}api/update-user', 
                    formData,
                    {
                        headers: {
                          'Content-Type': 'multipart/form-data'
                        }
                    }).then((response) => {
                        if (response.data.result) {
                            this.message.success = 'Account created successfully. Please wait you are being redirected.';
                            this.message.failure = '';

                            window.location.href = response.data.redirectTo;
                        } else {
                            this.message.failure = 'There is some error in creating account. Kindly try again.';
                            this.message.success = '';
                        }
                    }).catch((error) => {
                        if (error.response.status == 422){
                            this.sign_up_errors = error.response.data.errors;
                        } else {
                            this.message.failure = 'There is some error in creating account. Kindly try again.';
                            this.message.success = '';
                        }
                    });
                }
            },

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

<script>        
    let digitValidate = function(ele) {
        ele.value = ele.value.replace(/[^0-9]/g,'');
    }
</script>
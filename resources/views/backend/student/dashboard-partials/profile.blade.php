<div class="profileContent">
    <div class="head">
        <p class="title">Edit Profile</p>
    </div>
    <div class="contentInfo">
        <div class="form mt-4">
            <form method="POST" class="editProfileForm" action="{{ route('user.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="formFields">
                	<div class="">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" value="{{ request()->user()->username }}" readonly>
                    </div>
                    <div class="">
                        <label for="name">Your Name</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ request()->user()->name }}" required>
                        @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <label for="number">Phone Number
                        <div class="numberCont">
                            <div class="form-group">
                                <label class="wrap">
                                    <select class="form-control" id="selectNumber">
                                        <option>+91</option>
                                    </select>
                                </label>
                            </div>
                            <input class="formControl" type="tel" name="number" pattern="^[0]?[789]\d{9}$" value="{{ request()->user()->phone_number }}" id="number" required="" autocomplete="off" readonly>
                        </div>
                    </label>
                    <div class="">
                        <label for="email">Mail Id</label>
                        <input type="email" class="form-control" id="email" value="{{ request()->user()->email }}" readonly>
                    </div>
                    <div class="">
                        <label for="dob">Date of Birth</label>
                        <input name="dob" type="date" class="form-control" id="dob" value="{{ isset(request()->user()->other_details['dob']) ? request()->user()->other_details['dob'] : NULL }}">
                        @error('dob')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <label for="gender">Gender
                        <select name="gender" class="form-select" id="gender">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ isset(request()->user()->other_details['gender']) && (request()->user()->other_details['gender'] == 'Male') ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ isset(request()->user()->other_details['gender']) && (request()->user()->other_details['gender'] == 'Female') ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </label>
                    <label for="designation">I'm
                        <select name="designation" class="form-select" id="designation">
                            <option value="">Select</option>
                            <option value="Future Pilot" {{ isset(request()->user()->other_details['designation']) && (request()->user()->other_details['designation'] == 'Future Pilot') ? 'selected' : '' }}>Future Pilot</option>
                            <option value="Trainee pilot" {{ isset(request()->user()->other_details['designation']) && (request()->user()->other_details['designation'] == 'Trainee pilot') ? 'selected' : '' }}>Trainee pilot</option>
                            <option value="Airline Pilot" {{ isset(request()->user()->other_details['designation']) && (request()->user()->other_details['designation'] == 'Airline Pilot') ? 'selected' : '' }}>Airline Pilot</option>
                            <option value="Aviation enthusiastic" {{ isset(request()->user()->other_details['designation']) && (request()->user()->other_details['designation'] == 'Aviation enthusiastic') ? 'selected' : '' }}>Aviation enthusiastic</option>
                        </select>
                        @error('designation')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </label>
                    <div class="">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control" id="address" placeholder="Address">{{ isset(request()->user()->other_details['address']) ? request()->user()->other_details['address'] : NULL }}</textarea>
                        @error('address')
                            <div class="error">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="">
                        <label>Current Profile Picture</label><br>
                        @if (request()->user()->profilePicture)
                            <img src="{{ request()->user()->profilePicture->path }}" style="height: 100px; width: auto;">
                        @else
                            N/A
                        @endif
                    </div>
                    <div class="">
                        <label for="picture">New Profile Picture</label>
                        <input name="picture" type="file" class="form-control" id="picture" accept="image/*">
                        @error('picture')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="goal">My Goal</label>
                        <textarea name="goal" class="form-control" id="goal" placeholder="My Goal">{{ isset(request()->user()->other_details['goal']) ? request()->user()->other_details['goal'] : NULL }}</textarea>
                        @error('goal')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="">
                        @if (isset(request()->user()->other_details['newsletter']))
                            <input type="checkbox" id="newsletter" name="newsletter" value="1" checked>
                        @elseif (is_null(request()->user()->other_details['newsletter']))
                            <input type="checkbox" id="newsletter" name="newsletter" value="1">
                        @else
                            <input type="checkbox" id="newsletter" name="newsletter" value="1" checked>
                        @endif
    
                        <label for="newsletter"> Subscribe me to Newsletter.</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnRed">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
<x-app>
    <div class="untree_co-section">
        <div class="container">

            <div class="row">

                <h2 class="h3 mb-3 text-black">Register</h2>
                <div class="col-md-6 bg-success opacity-75">
                    <h1
                        style="font-size: 100px;
                          margin-top: 285px;
                          margin-left: 200px;
                          color: white;">
                        Furni
                    </h1>
                </div>

                <div class="col-md-6 p-3 p-lg-5 border bg-white">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="c_country" class="text-black">Country <span class="text-danger">*</span></label>
                            <select id="c_country" class="form-control" name="country">
                                <option value="1">Select a country</option>
                                <option value="2">bangladesh</option>
                                <option value="3">Algeria</option>
                                <option value="4">Afghanistan</option>
                                <option value="5">Ghana</option>
                                <option value="6">Albania</option>
                                <option value="7">Bahrain</option>
                                <option value="8">Colombia</option>
                                <option value="9">Dominican Republic</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                        <label for="role" class="text-black">Role <span class="text-danger">*</span></label>
                        <select id="role" class="form-control" name="role_id">
                            <option value="1">Select a Role</option>
                        </select>
                    </div> --}}
            

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_fname" class="text-black">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_fname" name="fast_name">
                            </div>
                            <div class="col-md-6">
                                <label for="c_lname" class="text-black">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_lname" name="last_name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_companyname" class="text-black">Company Name </label>
                                <input type="text" class="form-control" id="c_companyname" name="c_companyname">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_address" class="text-black">Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_address" name="c_address"
                                    placeholder="Street address">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <input type="text" class="form-control"
                                placeholder="Apartment, suite, unit etc. (optional)">
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_state_country" class="text-black">State / Country <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_state_country" name="c_state_country">
                            </div>
                            <div class="col-md-6">
                                <label for="c_postal_zip" class="text-black">Posta / Zip <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_email_address" class="text-black">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_email_address" name="email"
                                    placeholder="Enter Email Address">
                            </div>
                            <div class="col-md-6">
                                <label for="c_phone" class="text-black">Phone <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_phone" name="c_phone"
                                    placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="from-group row md-5">
                            <div class="col-md-6">
                                <label for="password" class="text-dark">{{ __('Password') }}</label>

                                <div class="">
                                    <input id="password" type="password" placeholder="Enter Password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="text-dark">{{ __('Confirm Password') }}</label>

                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm Passeord">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <div class="row">
                                <button type="submit"
                                    class="btn btn-black btn-lg py-3 btn-block">Registration</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>
</x-app>

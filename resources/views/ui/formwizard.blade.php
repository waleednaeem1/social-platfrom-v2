<x-app-layout>

       <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                        <div class="inner-page-title">
                        <h3 class="text-white">Simple Wizard Page</h3>
                        <p class="text-white">lorem ipsum</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Simple Wizard</h4>
                        </div>
                        </div>
                        <div class="card-body">
                        <form id="form-wizard1" class="text-center mt-3">
                            <ul id="top-tab-list" class="p-0 row list-inline">
                                <li class="col-lg-3 col-md-6 text-start mb-2 active" id="account">
                                    <a href="javascript:void();">
                                        <i class="material-symbols-outlined">
                                            lock_open
                                        </i>
                                        <span>Account</span>
                                    </a>
                                </li>
                                <li id="personal" class="col-lg-3 col-md-6 mb-2 text-start">
                                    <a href="javascript:void();">
                                        <i class="material-symbols-outlined">
                                            person
                                        </i>
                                        <span>Personal</span>
                                    </a>
                                </li>
                                <li id="payment" class="col-lg-3 col-md-6 mb-2 text-start">
                                    <a href="javascript:void();">
                                        <i class="material-symbols-outlined">
                                            photo_camera
                                        </i>
                                        <span>Image</span>
                                    </a>
                                </li>
                                <li id="confirm" class="col-lg-3 col-md-6 mb-2 text-start">
                                    <a href="javascript:void();">
                                        <i class="material-symbols-outlined">
                                            done
                                        </i>
                                        <span>Finish</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card text-start">
                                    <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4">Account Information:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 1 - 4</h2>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email: *</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email Id" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Username: *</label>
                                            <input type="text" class="form-control" name="username" placeholder="UserName" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Password: *</label>
                                            <input type="password" class="form-control" name="pwd" placeholder="Password" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password: *</label>
                                            <input type="password" class="form-control" name="cpwd" placeholder="Confirm Password" />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Next" >Next</button>
                            </fieldset>
                            <fieldset>
                                <div class="form-card text-start">
                                    <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4">Personal Information:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 2 - 4</h2>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">First Name: *</label>
                                            <input type="text" class="form-control" name="first_name" placeholder="First Name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Last Name: *</label>
                                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Contact No.: *</label>
                                            <input type="text" class="form-control" name="phno" placeholder="Contact No." />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Alternate Contact No.: *</label>
                                            <input type="text" class="form-control" name="phno_2" placeholder="Alternate Contact No." />
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Next" >Next</button>
                                <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-3" value="Previous" >Previous</button>
                            </fieldset>
                            <fieldset>
                                <div class="form-card text-start">
                                    <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4">Image Upload:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 3 - 4</h2>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label">Upload Your Photo:</label>
                                    <input type="file" class="form-control" name="pic" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label">Upload Signature Photo:</label>
                                    <input type="file" class="form-control" name="pic-2" accept="image/*">
                                    </div>
                                </div>
                                <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Submit" >Submit</button>
                                <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-3" value="Previous" >Previous</button>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4 text-left">Finish:</h3>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 4 - 4</h2>
                                    </div>
                                    </div>
                                    <br><br>
                                    <h2 class="text-success text-center"><strong>SUCCESS !</strong></h2>
                                    <br>
                                    <div class="row justify-content-center">
                                    <div class="col-3"> <img src="{{asset('images/page-img/img-success.png')}}" class="img-fluid" alt="fit-image"> </div>
                                    </div>
                                    <br><br>
                                    <div class="row justify-content-center">
                                    <div class="col-7 text-center">
                                        <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>
                                    </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</x-app-layout>
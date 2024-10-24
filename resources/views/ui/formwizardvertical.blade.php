<x-app-layout>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                    <div class="inner-page-title">
                        <h3 class="text-white">Vertical Wizard Page</h3>
                        <p class="text-white">lorem ipsum</p>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Vertical Wizard</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <ul id="top-tabbar-vertical" class="p-0">
                                <li class="active step1" id="personal">
                                    <a href="javascript:void();">
                                        <i class="material-symbols-outlined bg-soft-primary text-primary">
                                            lock_open
                                        </i>
                                        <span>Personal</span>
                                    </a>
                                </li>
                                <li id="contact" class="step2">
                                    <a href="javascript:void();">
                                        <i class="material-symbols-outlined bg-soft-danger text-danger">
                                            person
                                        </i>
                                        <span>Contact</span>
                                    </a>
                                </li>
                                <li id="official" class="step3">
                                    <a href="javascript:void();">
                                        <i class="material-symbols-outlined bg-soft-success text-success">
                                            photo_camera
                                        </i>
                                        <span>Official</span>
                                    </a>
                                </li>
                                <li id="payment" class="step4">
                                    <a href="javascript:void(0);">
                                        <i class="material-symbols-outlined bg-soft-warning text-warning">
                                            done
                                        </i>
                                        <span>Payment</span>
                                    </a>
                                </li>
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <form id="form-wizard3" class="text-start">
                                <!-- fieldsets -->
                                <fieldset>
                                    <div class="form-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                            <h3 class="mb-4">User Information:</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="first_name">First Name: *</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required="required" />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="last_name">Last Name: *</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Gender: *</label>
                                                <div class="form-check">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="customRadio" id="customRadio1">
                                                        <label class="form-check-label" for="customRadio1"> Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="customRadio" id="customRadio2">
                                                        <label class="form-check-label" for="customRadio2"> Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="dob">Date Of Birth: *</label>
                                                <input type="date" class="form-control" id="dob" name="dob" />
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="submit" type="button" name="next" class="btn btn-primary next action-button float-end" value="Next" >Next</button>
                                </fieldset>
                                <fieldset>
                                    <div class="form-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                            <h3 class="mb-4">Contact Information:</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email Id: *</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Id" />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="ccno">Contact Number: *</label>
                                                <input type="text" class="form-control" id="ccno" name="ccno" placeholder="Contact Number" />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="city">City: *</label>
                                                <input type="text" class="form-control" id="city" name="city" placeholder="City." />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="state">State: *</label>
                                                <input type="text" class="form-control" id="state" name="state" placeholder="State." />
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Next" >Next</button>
                                    <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-3" value="Previous" >Previous</button>
                                </fieldset>
                                <fieldset>
                                    <div class="form-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                            <h3 class="mb-4">Official Information:</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="empid">Employee Id: *</label>
                                                <input type="email" class="form-control" id="empid" name="empid" placeholder="Employee Id." />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="desg">Designation: *</label>
                                                <input type="text" class="form-control" id="desg" name="desg" placeholder="Designation." />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="accname">Departmrnt Name: *</label>
                                                <input type="text" class="form-control" id="accname" name="accname" placeholder="Departmrnt Name." />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="workhour">Working Hour: *</label>
                                                <input type="text" class="form-control" id="workhour" name="workhour" placeholder="Working Hour." />
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" name="next" class="btn btn-primary next action-button float-end" value="Submit" >Submit</button>
                                    <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-3" value="Previous" >Previous</button>
                                </fieldset>
                                <fieldset>
                                    <div class="form-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                            <h3 class="mb-4 text-left">Payment:</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="panno">Pan No: *</label>
                                                <input type="text" class="form-control" id="panno" name="panno" placeholder="Pan No." />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="accno">Account No: *</label>
                                                <input type="text" class="form-control" id="accno" name="accno" placeholder="Account No." />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="holname">Account Holder Name: *</label>
                                                <input type="text" class="form-control" id="holname" name="accname" placeholder="Account Holder Name." />
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="ifsc">IFSC Code: *</label>
                                                <input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="IFSC Code." />
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-primary action-button float-end" href="{{route('formwizardvertical')}}" >Submit</a>
                                    <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-end me-3" value="Previous" >Previous</button>
                                </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    
</x-app-layout>
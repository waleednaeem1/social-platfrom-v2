<x-app-layout>
<div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                    <div class="inner-page-title">
                        <h3 class="text-white">Validate Wizard Page</h3>
                        <p class="text-white">lorem ipsum</p>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Validate Wizard</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="stepwizard mt-4">

                        </div>
                        <form class="form" method="post" id="registration">
                            <nav>
                                <div class="nav nav-pills nav-fill stepwizard-row" id="nav-tab" role="tablist">
                                    <a class="nav-link btn active" id="user-tab" data-toggle="tab" href="#user-detail">
                                        <i class="material-symbols-outlined bg-soft-primary text-primary">
                                            lock_open
                                        </i>
                                        <span>User Detail</span>
                                    </a>
                                    <a class="nav-link btn" id="document-tab" data-toggle="tab" href="#document-detail">
                                        <i class="material-symbols-outlined bg-soft-danger text-danger">
                                            person
                                        </i>
                                        <span>Document Detail</span>
                                    </a>
                                    <a class="nav-link btn" id="bank-tab" data-toggle="tab" href="#bank-detail">
                                        <i class="material-symbols-outlined bg-soft-success text-success">
                                            photo_camera
                                        </i>
                                        <span>Bank Detail</span>
                                    </a>
                                    <a class="nav-link btn" id="cpnfirm-tab" data-toggle="tab" href="#cpnfirm-data">
                                        <i class="material-symbols-outlined bg-soft-warning text-warning">
                                            done
                                        </i>
                                        <span>Confirm</span>    
                                    </a>
                                </div>
                            </nav>
                            <div class="tab-content pt-4 pb-2" id="nav-tabContent">                                
                                <div class="row tab-pane fade show active" id="user-detail">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 p-0">
                                            <h3 class="mb-4">User Information:</h3>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">First Name</label>
                                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Last Name</label>
                                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="username" class="form-label">User Name: *</label>
                                                    <input type="text" class="form-control" id="username" required="required" name="username" placeholder="Enter User Name">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="emailid" class="form-label">Email Id: *</label>
                                                    <input type="email" id="emailid" class="form-control" required="required" name="emailid" placeholder="Email ID">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="pwd" class="form-label">Password: *</label>
                                                    <input type="password" class="form-control" required="required" id="pwd" name="pwd" placeholder="Password">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="cpwd" class="form-label">Confirm Password: *</label>
                                                    <input type="password" class="form-control" id="cpwd" required="required" name="cpwd" placeholder="Confirm Password">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="cno" class="form-label">Contact Number: *</label>
                                                    <input type="text" class="form-control" required="required" id="cno" name="cno" placeholder="Contact Number">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="acno" class="form-label">Alternate Contact Number: *</label>
                                                    <input type="text" class="form-control" required="required" id="acno" name="acno" placeholder="Alternate Contact Number">
                                                </div>
                                                <div class="col-md-12 mb-3 form-group">
                                                    <label for="address" class="form-label">Address: *</label>
                                                    <textarea name="address" class="form-control" id="address" rows="5" required="required"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row tab-pane fade" id="document-detail">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 p-0">
                                            <h3 class="mb-4">Document Details:</h3>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="first_name" class="form-label">Company Name: *</label>
                                                    <input type="text" class="form-control" required="required" id="first_name" name="first_name" placeholder="Company Name">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="form-group">
                                                    <label for="ccno" class="form-label">Contact Number: *</label>
                                                    <input type="text" class="form-control" required="required" id="ccno" name="ccno" placeholder="Contact Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="form-group">
                                                    <label for="url" class="form-label">Company Url: *</label>
                                                    <input type="text" class="form-control" required="required" id="url" name="url" placeholder="Company Url.">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <div class="form-group">
                                                    <label for="cemail" class="form-label">Company Mail Id: *</label>
                                                    <input type="email" class="form-control" required="required" id="cemail" name="cemail" placeholder="Company Mail Id.">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                    <label for="cadd" class="form-label">Company Address: *</label>
                                                    <textarea name="cadd" required="required" id="cadd" class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row tab-pane fade" id="bank-detail">
                                    <div class="col-sm-12">
                                    <div class="col-md-12 p-0">
                                        <h3 class="mb-4">Bank Detail:</h3>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="panno" class="form-label">Pan No: *</label>
                                                <input type="text" class="form-control" required="required" id="panno" name="panno" placeholder="Pan No.">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="accno" class="form-label">Account No: *</label>
                                                <input type="text" class="form-control" required="required" id="accno" name="accno" placeholder="Account No.">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="accname" class="form-label">Account Holder Name: *</label>
                                                <input type="text" class="form-control" required="required" id="accname" name="accname" placeholder="Account Holder Name.">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="ifsc" class="form-label">IFSC Code: *</label>
                                                <input type="text" class="form-control" required="required" id="ifsc" name="ifsc" placeholder="IFSC Code.">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="bankname" class="form-label">Bank Name: *</label>
                                                <input type="text" class="form-control" required="required" id="bankname" name="bankname" placeholder="Bank Name.">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="branch" class="form-label">Bank Branch Name: *</label>
                                                <input type="text" class="form-control" required="required" id="branch" name="branch" placeholder="Bank Branch Name.">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row tab-pane fade" id="cpnfirm-data">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 p-0">
                                            <h3 class="mb-4 text-left">Finish:</h3>
                                            <div class="row justify-content-center">
                                                <div class="col-3"> <img src="{{asset('images/page-img/img-success.png')}}" class="img-fluid" alt="img-success"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="col-auto"><button type="button" class="btn btn-secondary" data-enchanter="previous" disabled="disabled">Previous</button></div>
                                <div class="col-auto">
                                <button type="button" class="btn btn-primary" data-enchanter="next">Next</button>
                                <button type="submit" class="btn btn-primary d-none" data-enchanter="finish">Finish</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    
</x-app-layout>
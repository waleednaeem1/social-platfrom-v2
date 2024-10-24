<x-app-layout>
   <div class="container">
      @if(isset($id))
      <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
                        <div class="iq-edit-list">
                            <ul class="iq-edit-profile row nav nav-pills">
                                <li class="col-md-4 p-0">
                                    <a class="nav-link active" data-bs-toggle="pill" href="#personal-information">
                                        Personal Information
                                    </a>
                                </li>
                                <li class="col-md-4 p-0">
                                    <a class="nav-link" data-bs-toggle="pill" href="#chang-pwd">
                                        Change Password
                                    </a>
                                </li>
                                <li class="col-md-4 p-0">
                                    <a class="nav-link" data-bs-toggle="pill" href="#emailandsms">
                                        Email and SMS
                                    </a>
                                </li>
                                </ul>
                        </div>
            </div>
         </div>
      </div>
      @endif
      <div class="col-lg-12"> 
            <div class="iq-edit-list-data">
               <div class="tab-content">
               <?php
                     $id = $id ?? null;
                  ?>
                  <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">{{$id !== null ? 'Update' : 'Add' }} User's Personal Information</h4>
                           </div>
                        </div>
                        <div class="card-body">
                        
                        @if(isset($id))
                        {!! Form::model($data, ['route' => ['users.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
                        @else
                        {!! Form::open(['route' => ['users.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                        @endif
                              <div class="form-group">
                                 <div class="col-md-12 text-center">
                                    <div class="profile-img-edit">
                                    <img class="profile-pic" src="{{asset('images/user/11.png')}}" alt="profile-pic">
                                       <div class="p-image">
                                             <i class="ri-pencil-line upload-button text-white"></i>
                                             <input class="file-upload" type="file" accept="image/*">
                                       </div>
                                    </div>
                                 </div>
                                 
                              
                              
                                 <label class="form-label">Status:</label>
                                 <div class="grid" style="--bs-gap: 1rem">
                                    <div class="form-check g-col-6">
                                       {{ Form::radio('status', 'active',old('status') || true, ['class' => 'form-check-input', 'id' => 'status-active']) }}
                                       <label class="form-check-label" for="status-active">
                                             Active
                                       </label>
                                    </div>
                                    <div class="form-check g-col-6">
                                       {{ Form::radio('status', 'pending',old('status'), ['class' => 'form-check-input', 'id' => 'status-pending']) }}
                                       <label class="form-check-label" for="status-pending">
                                             Pending
                                       </label>
                                    </div>
                                    <div class="form-check g-col-6">
                                       {{ Form::radio('status', 'banned',old('status'), ['class' => 'form-check-input', 'id' => 'status-banned']) }}
                                       <label class="form-check-label" for="status-banned">
                                             Banned
                                       </label>
                                    </div>
                                    <div class="form-check g-col-6">
                                       {{ Form::radio('status', 'inactive',old('status'), ['class' => 'form-check-input', 'id' => 'status-inactive']) }}
                                       <label class="form-check-label" for="status-inactive">
                                             Inactive
                                       </label>
                                    </div>
                                 </div>
                              
                              
                              
                        </div>
                     
                             
                     <!-- <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">{{$id !== null ? 'Update' : 'New' }} User Information</h4>
                           </div>
                           <div class="card-action">
                                 <a href="{{route('users.index')}}" class="btn btn-sm btn-primary" role="button">Back</a>
                           </div>
                     </div> -->
                        
                     <div class=" row align-items-center">
                        
                           <div class="form-group col-md-6">
                              <label class="form-label" for="fname">First Name: <span class="text-danger">*</span></label>
                              {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name', 'required']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="lname">Last Name: <span class="text-danger">*</span></label>
                              {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name' ,'required']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="uname">User Name: <span class="text-danger">*</span></label>
                              {{ Form::text('username', old('username'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter Username']) }}
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-label" for="add1">Street Address 1:</label>
                              {{ Form::text('userProfile[street_addr_1]', old('userProfile[street_addr_1]'), ['class' => 'form-control', 'id' => 'add1', 'placeholder' => 'Enter Street Address 1']) }}
                           </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="add2">Street Address 2:</label>
                                 {{ Form::text('userProfile[street_addr_2]', old('userProfile[street_addr_2]'), ['class' => 'form-control', 'id' => 'add2', 'placeholder' => 'Enter Street Address 2']) }}
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label">User Role: <span class="text-danger">*</span></label>
                                 {{Form::select('user_role', $roles ?? '' , old('user_role') ? old('user_role') : $data->user_type ?? 'user', ['class' => 'form-control', 'placeholder' => 'Select User Role'])}}
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="cname">Company Name: <span class="text-danger">*</span></label>
                                 {{ Form::text('userProfile[company_name]', old('userProfile[company_name]'), ['class' => 'form-control', 'required', 'placeholder' => 'Company Name']) }}
                              </div>
                              <div class="form-group col-sm-6">
                                 <label class="form-label" id="country">Country:</label>
                                 {{ Form::text('userProfile[country]', old('userProfile[country]'), ['class' => 'form-control', 'id' => 'country']) }}

                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="mobno">Mobile Number:</label>
                                 {{ Form::text('phone_number', old('phone_number'), ['class' => 'form-control', 'id' => 'mobno', 'placeholder' => 'Mobile Number']) }}
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="altconno">Alternate Contact:</label>
                                 {{ Form::text('userProfile[alt_phone_number]', old('userProfile[alt_phone_number]'), ['class' => 'form-control', 'id' => 'altconno', 'placeholder' => 'Alternate Contact']) }}
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="email">Email: <span class="text-danger">*</span></label>
                                 {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Enter e-mail', 'required']) }}
                              </div>
                              <div class="form-group col-md-6">
                                 <label class="form-label" for="pno">Pin Code:</label>
                                 {{ Form::number('userProfile[pin_code]', old('userProfile[pin_code]'), ['class' => 'form-control', 'id' => 'pin_code','step' => 'any']) }}
                              </div>
                              @if(!$id)
                              <div class="form-group col-md-6">
                                    <label class="form-label" for="pass">New Password:</label>
                                    {{ Form::password('password',['class' => 'form-control', 'placeholder' => 'Password']) }}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="rpass">Confirm Password:</label>
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Repeat Password']) }}
                                </div>
                              @endif
                              <div class="form-group col-md-12">
                                 <label class="form-label" for="city">Town/City:</label>
                                 {{ Form::text('userProfile[city]', old('city'), ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'Enter City Name' ]) }}
                                 
                              </div>
                              
                           </div>
                           <button type="submit" class="btn btn-primary">{{$id !== null ? 'Update' : 'Add' }} User</button>
                           <button type="reset" class="btn btn-primary">Cancel</button>
                              {!! Form::close() !!}
                        </div>
                     </div>
                  </div>
                  @if(isset($id))
                  <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                            <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                        <h4 class="card-title">Change Password</h4>
                                </div>
                            </div>                        
                            
                            <div class="card-body">
                            {!! Form::open(['route' => ['changepasswordpost', $id], 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
                                 <div class="form-group col-md-6">
                                    <label class="form-label" for="cpass">Current Password:</label>
                                    {{ Form::password('current_password',['class' => 'form-control', 'placeholder' => 'Current Password']) }}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="pass">New Password:</label>
                                    {{ Form::password('new_password',['class' => 'form-control', 'placeholder' => 'Password']) }}
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="rpass">Confirm Password:</label>
                                    {{ Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => 'Repeat Password']) }}
                                </div>
                                <button type="submit" class="btn btn-primary">{{$id !== null ? 'Update' : 'Add' }} Password</button>
                                {!! Form::close() !!}
                            </div>
                            </div>
                     </div>
                     @endif

               </div>
            </div> 
         </div>  
       </div>
   </div>
</x-app-layout>

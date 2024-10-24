<x-app-layout>
    <div class="container">
    @php
        $user = auth()->user();
        // echo "<pre>";
        //     print_r($user->email);
        //     die;
    @endphp
            <div class="row">
                <div class="col-x-8 m-0 py-0 rem-div-1">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Signature</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="accountSettingsuccess"></div>
                                    <div class="acc-edit">
                                        <form action="{{ route('users.update',$user->id ?? '') }}" class="createSignatureFormSubmit" id="createSignatureFormSubmit" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" class="form-control" id="accountSetting" name="id" value={{$user->id}}>
                                            <div class="form-group">
                                                <label for="first_name" class="form-label">First Name:</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{$user->first_name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name" class="form-label">Last Name:</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{$user->last_name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Phone:</label>
                                                <input type="phone" class="form-control" id="signature_phone" name="signature_phone"  value="{{$user->phone}}">
                                            </div>
                                            <button id="createSignatureButtonClick" type="submit" class="btn btn-primary me-2">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Signature</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table style="width: 100%; font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                                        <tr>
                                            <td style="width: 80px; vertical-align: top;">
                                                <div style="width: 60px; height: 60px; overflow: hidden; border-radius: 50%;">
                                                    
                                                    @if(isset($user->avatar_location) && $user->avatar_location !== '')
                                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" class="img-fluid rounded-circle me-3" width="100px" height="100px"  alt="user" loading="lazy">
                                                    @else
                                                        <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="img-fluid rounded-circle me-3" loading="lazy">
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="padding-left: 10px; vertical-align: top;">
                                                <span style="font-size: 18px; font-weight: bold;">{{$user->first_name.' '.$user->last_name}}</span><br>
                                                <span style="font-size: 14px; color: #666;">{{$user->type}}</span><br>
                                                <span style="font-size: 14px; color: #13a3709a;">Devsinc.</span>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td colspan="2" style="padding: 5px 0;">
                                                <i class="fas fa-phone" style="color: #13a3709a; margin-right:5px"></i> <a href="tel:{{$user->phone}}" style="color: #007bff; text-decoration: none;">{{$user->phone}}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 5px 0;">
                                                <i class="fas fa-envelope" style="color: #13a3709a; margin-right:5px"> </i><a href="mailto:{{$user->email}}" style="color: #007bff; text-decoration: none;">{{$user->email}}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 5px 0;">
                                                <i class="fas fa-globe" style="color: #13a3709a; margin-right:5px"></i> <a href="https://www.devsinc.com" style="color: #007bff; text-decoration: none;">www.devsinc.com</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Signature <span><button onclick="copySignature()" class="btn btn-primary" style="margin-left:160px">Copy Signature</button></span></h4>
                                        {{-- <button onclick="copySignature()" class="btn btn-primary">Copy Signature</button> --}}
                                    </div>
                                </div>
                                <div class="card-body" id="signatureContent">
                                    <table style="width: 100%; font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                                        <tr>
                                            <td style="width: 80px; vertical-align: top;">
                                                <div style="width: 60px; height: 60px; overflow: hidden; border-radius: 50%;">
                                                    @if(isset($user->avatar_location) && $user->avatar_location !== '')
                                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" style="width: 100%; height: auto; border-radius: 50%;" alt="user" loading="lazy">
                                                    @else
                                                        <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" style="width: 100%; height: auto; border-radius: 50%;" loading="lazy">
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="padding-left: 10px; vertical-align: top;">
                                                <span style="font-size: 18px; font-weight: bold;">{{$user->first_name.' '.$user->last_name}}</span><br>
                                                <span style="font-size: 14px; color: #666;">{{$user->type}}</span><br>
                                                <span style="font-size: 14px; color: #13a370;">Devsinc.</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 5px 0;">
                                                <i class="fas fa-phone" style="color: #13a370; margin-right:5px"></i> <a href="tel:{{$user->phone}}" style="color: #007bff; text-decoration: none;">{{$user->phone}}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 5px 0;">
                                                <i class="fas fa-envelope" style="color: #13a370; margin-right:5px"> </i><a href="mailto:{{$user->email}}" style="color: #007bff; text-decoration: none;">{{$user->email}}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding: 5px 0;">
                                                <i class="fas fa-globe" style="color: #13a370; margin-right:5px"></i> <a href="https://www.devsinc.com" style="color: #007bff; text-decoration: none;">www.devsinc.com</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
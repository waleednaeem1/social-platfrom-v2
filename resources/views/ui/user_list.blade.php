<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                <div class="inner-page-title">
                    <h3 class="text-white">Data Table Page</h3>
                    <p class="text-white">lorem ipsum</p>
                </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Bootstrap Datatables</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Images in Bootstrap are made responsive with <code>.img-fluid</code>. <code>max-width: 100%;</code> and <code>height: auto;</code> are applied to the image so that it scales with the parent element.</p>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" >
                            <thead>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse($users as $user)
                                    <tr>
                                        <th>{{$user->id}}</th>
                                        <th>{{$user->username}}</th>
                                        <th>{{$user->first_name}}</th>
                                        <th>{{$user->last_name}}</th>
                                        <th>{{$user->email}}</th>
                                        <th>{{$user->phone_number}}</th>
                                        <th>{{$user->user_type}}</th>
                                        <th>{{$user->status}}</th>
                                    </tr>
                                    @empty
                                        <p>No user</p>
                                    @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Update Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ url('/admin/update-current-password') }}" name="updatePasswordForm" id="updatePasswordForm">
                  @csrf
                    {{-- For Error Messages --}}
                    @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible mt-2 mx-2 fade show" role="alert">
                        {{ Session::get('error_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif
                    {{-- For Success Messages --}}
                    @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible mt-2 mx-2 fade show" role="alert">
                        {{ Session::get('success_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif

                  <div class="card-body">
                    
                    {{-- <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" placeholder="Admin Name" name="admin_name" id="admin_name"
                        value="{{ $adminDetails->name }}">
                    </div> --}}

                    <div class="form-group">
                        <label for="exampleInputEmail1">Admin Email</label>
                        <input class="form-control" value="{{ $adminDetails->email }}" readonly>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Admin Type</label>
                      <input class="form-control" value="{{ $adminDetails->type }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="current_password">Current Password</label>
                      <input type="password" class="form-control" name="current_password" id="current_password" 
                      placeholder="Enter Current Password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control"  name="new_password" id="new_password"
                         placeholder="Enter New Password" required>
                      </div>
                    
                    <div class="form-group">
                      <label for="confirm_password">Confirm Password</label>
                      <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                       placeholder="Enter Confirm Password" required>
                    </div>
                    
    
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
  
            </div>
            <!--/.col (left) -->
    
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

</div>
  <!-- /.content-wrapper -->

@endsection
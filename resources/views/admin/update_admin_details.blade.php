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
                  <h3 class="card-title">Update Admin Details</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ url('/admin/update-admin-details') }}" name="updateAdminDetailsForm" 
                id="updateAdminDetailsForm" enctype="multipart/form-data">
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
                    {{-- For Validation Errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                  <div class="card-body">

                    <div class="form-group">
                        <label for="email">Admin Email</label>
                        <input class="form-control" id="email" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                    </div>
                    
                    <div class="form-group">
                      <label for="type">Admin Type</label>
                      <input class="form-control" id="type" value="{{ Auth::guard('admin')->user()->type }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" placeholder="Enter Name" name="name" id="name"
                        value="{{ Auth::guard('admin')->user()->name }}">
                    </div>

                    <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="text" class="form-control" name="mobile" id="mobile" 
                      placeholder="Enter Mobile Number" value="{{ Auth::guard('admin')->user()->mobile }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        @if(!empty(Auth::guard('admin')->user()->image))
                          <a target="_blank" href="{{ url('images/admin/admin_photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                          <input type="hidden" name="current_image" value="{{ Auth::guard('admin')->user()->image }}">
                        @endif
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
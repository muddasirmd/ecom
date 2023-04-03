@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Banners</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
             {{-- For Success Messages --}}
             @if(Session::has('success_message'))
             <div class="alert alert-success alert-dismissible mt-2 mx-2 fade show" role="alert">
                 {{ Session::get('success_message') }}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             @endif
             
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Banners</h3>
                <a href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display:inline-block">
                    Add Banner</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="banners" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($banners as $banner)
                        
                        <tr>
                            <td>{{ $banner->id }}</td>
                            <td>{{ $banner->title }}</td>
                            <td>{{ $banner->link }}</td>
                            <td>
                              @if (!empty($banner->image) && file_exists('images/admin/banner_images/'.$banner->image))
                                <img style="width: 100px" src="{{ asset('images/admin/banner_images/'.$banner->image) }}">
                              @else
                                <img style="width: 100px" src="{{ asset('images/admin/no_image.png') }}">
                              @endif
                              </td>
                            <td>
                                @if ($banner->status == 1)
                                    <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{$banner->id}}" 
                                      banner_id='{{$banner->id}}'><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                @else
                                    <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{$banner->id}}" 
                                      banner_id='{{$banner->id}}'><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                @endif
                            </td>
                            <td>
                    
                              <a title="Edit Banner" href="{{ url('admin/add-edit-banner/'.$banner->id) }}"><i class="fas fa-edit"></i></a>
                              &nbsp;&nbsp;
                            
                              <a title="Delete Banner" href="javascript:void(0)" class="confirmDelete" record='banner' recordid='{{$banner->id}}'><i class="fas fa-trash"></i></a>
                          </td>
                        </tr>
                    @endforeach
                  
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
@endsection
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
                            <li class="breadcrumb-item"><a href="{{ url('admin/banners') }}">Banners</a></li>
                            <li class="breadcrumb-item active">Banner Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

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
                {{-- For Success Messages --}}
                @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible mt-2 mx-2 fade show" role="alert">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form id="bannerForm" name="bannerForm" method="POST"
                    action="{{ empty($banner->id) ? url('admin/add-edit-banner') : url('admin/add-edit-banner/' . $banner->id) }}"
                    enctype="multipart/form-data">@csrf
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="title">Banner Name</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter Banner Name"
                                            value="{{ !empty($banner->id) ? $banner->title : old('title') }}">
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="text" class="form-control" name="link" id="link"
                                            placeholder="Enter Banner Link"
                                            value="{{ !empty($banner->id) ? $banner->link : old('link') }}">
                                    </div>

                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">

                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label for="banner_price">Alternate Text</label>
                                        <input type="text" class="form-control" name="alt" id="alt"
                                            placeholder="Enter Alt"
                                            value="{{ !empty($banner->id) ? $banner->alt : old('alt') }}">
                                    </div>

                                </div>
                                
                                <div class="col-12 col-sm-6">
                                    
                                    <div class="form-group">
                                        <label for="image">Banner Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image"
                                                    id="image">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                        @if (!empty($banner->image) && file_exists('images/admin/banner_images/'.$banner->image))
                                            <div>
                                                <img style="width: 80px; margin-top:5px;"
                                                    src="{{ asset('images/admin/banner_images/' . $banner->image) }}">
                                                &nbsp;

                                                <a href="javascript:void(0)" class="confirmDelete" record='banner-image'
                                                    recordid='{{ $banner->id }}'>Delete Image</a>
                                            </div>
                                        @else
                                            <img style="width: 80px; margin-top:5px;" src="{{ asset('images/admin/no_image.png') }}">
                                        @endif
                                    </div> 
                                    <!-- /.form-group -->
                                </div>
                                
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
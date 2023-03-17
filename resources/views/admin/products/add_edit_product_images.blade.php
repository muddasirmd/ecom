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
                            <li class="breadcrumb-item"><a href="{{ url('admin/products') }}">Products</a></li>
                            <li class="breadcrumb-item active">Product Images Form</li>
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
                @elseif (Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible mt-2 mx-2 fade show" role="alert">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form id="addImagesForm" name="addImagesForm" method="POST" enctype="multipart/form-data"
                    action="{{ empty($product->id) ? url('admin/add-product-image') : url('admin/add-product-image/' . $product->id) }}">
                    @csrf
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
                                        <label for="product_name">Product Name:</label>&nbsp; {{$product->product_name}}
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="product_code">Product Code:</label>&nbsp; {{ $product->product_code }}
                                    </div>

                                    <div class="form-group">
                                        <label for="product_color">Product Color:</label>&nbsp; {{ $product->product_color }}
                                    </div>	

                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        
                                        @if (!empty($product->product_image) && file_exists('images/admin/product_images/small/'.$product->product_image))
                                            <div>
                                                <img style="width: 100px; margin-top:5px;"
                                                    src="{{ asset('images/admin/product_images/small/' . $product->product_image) }}">
                                            </div>
                                        @else
                                            <img style="width: 80px; margin-top:5px;" src="{{ asset('images/admin/no_image.png') }}">
                                        @endif
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="field_wrapper">
                                            
                                            <div>
                                                <input type="file" name="images[]" value="" multiple/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                           
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Images</button>
                        </div>
                    </div>
                </form>

                
                <div class="card">
                    <div class="card-header">
                      <h2 class="card-title">Added Product Images</h3>
                    </div>
                    <form id="editImageForm" name="editImageForm" method="POST" enctype="multipart/form-data"
                    action="{{ empty($product->id) ? url('admin/edit-product-image') : url('admin/edit-product-image/' . $product->id) }}">
                    @csrf
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($product->productImages as $img)
                                <tr>
                                    <input type="hidden" name="imageId[]" value="{{ $img->id }}">
                                    <td>{{ $img->id }}</td>
                                    <td>
                                        <img style="width: 100px; margin-top:5px;"
                                        src="{{ asset('images/admin/product_images/small/' . $img->image) }}">
                                    </td>
                                    
                                    <td>                                  
                                        @if ($img->status == 1)
                                            <a href="javascript:void(0)" class="updateProductImageStatus" id="product-image-{{$img->id}}" 
                                            product_image_id='{{$img->id}}'>Active</a>
                                        @else
                                            <a href="javascript:void(0)" class="updateProductImageStatus" id="product-image-{{$img->id}}" 
                                            product_image_id='{{$img->id}}'>Inactive</a>
                                        @endif
                                        &nbsp;&nbsp;
                                        <a title="Delete Image" href="javascript:void(0)" class="confirmDelete" record='product-images' recordid='{{$img->id}}'><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Edit Images</button>
                        </div>

                    </form>
                  </div>
                  <!-- /.card -->

            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
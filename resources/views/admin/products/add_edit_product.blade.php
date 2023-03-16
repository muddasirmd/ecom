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
                            <li class="breadcrumb-item active">Product Form</li>
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
                <form id="productForm" name="productForm" method="POST"
                    action="{{ empty($product->id) ? url('admin/add-edit-product') : url('admin/add-edit-product/' . $product->id) }}"
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
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name"
                                            placeholder="Enter Product Name"
                                            value="{{ !empty($product->id) ? $product->product_name : old('product_name') }}">
                                    </div>
                                   
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select name="category_id" id="category_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>

                                            @foreach ($sections as $section)
                                                <optgroup label="{{$section->name }}"></optgroup>

                                                @foreach ($section->categories as $category)
                                                    <option value={{ $category->id }}
                                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                       &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp; {{ $category->category_name }}</option>
                                                       @foreach ($category->subCategories as $subCategory)
                                                           <option value="{{ $subCategory->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp; {{ $subCategory->category_name }}</option>
                                                       @endforeach
                                                @endforeach

                                            @endforeach

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="product_color">Product Color</label>
                                        <input type="text" class="form-control" name="product_color" id="product_color"
                                            placeholder="Enter Product Color"
                                            value="{{ !empty($product->id) ? $product->product_color : old('product_color') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Select Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>
                                            @foreach ($brands as $brand)
                                                <option value={{ $brand->id }} {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->brand_name }}
                                                </option>
                                                       
                                                @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label for="product_code">Product Code</label>
                                        <input type="text" class="form-control" name="product_code" id="product_code"
                                            placeholder="Enter Product Code"
                                            value="{{ !empty($product->id) ? $product->product_code : old('product_code') }}">
                                    </div>
                                    <!-- /.form-group -->
                                    
                                    <div class="form-group">
                                        <label for="product_video">Product Video</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_video"
                                                    id="product_video">
                                                <label class="custom-file-label" for="product_video">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                        @if (!empty($product->product_video) && file_exists('videos/product_images/small/'.$product->product_video))
                                            <div>
                                                <a href="{{ url('images/admin_images/product_images/small/' . $product->product_image) }}" download>Download</a>
                                                &nbsp;|&nbsp;
                                                <a href="javascript:void(0)" class="confirmDelete" record='product-video'
                                                    recordid='{{ $product->id }}'>Delete Video</a>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">

                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_price">Product Price</label>
                                        <input type="text" class="form-control" name="product_price" id="product_price"
                                            placeholder="Enter Product Price"
                                            value="{{ !empty($product->id) ? $product->product_price : old('product_price') }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="product_image">Product Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_image"
                                                    id="product_image">
                                                <label class="custom-file-label" for="product_image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                        @if (!empty($product->product_image) && file_exists('images/admin_images/product_images/small/'.$product->product_image))
                                            <div>
                                                <img style="width: 80px; margin-top:5px;"
                                                    src="{{ asset('images/admin_images/product_images/small/' . $product->product_image) }}">
                                                &nbsp;

                                                <a href="javascript:void(0)" class="confirmDelete" record='product-image'
                                                    recordid='{{ $product->id }}'>Delete Image</a>
                                            </div>
                                        @else
                                            <img style="width: 80px; margin-top:5px;" src="{{ asset('images/admin_images/no_image.png') }}">
                                        @endif
                                    </div> 
                                    <!-- /.form-group -->
                                </div>
                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label for="product_discount">Product Discount</label>
                                        <input type="text" class="form-control" name="product_discount"
                                            id="product_discount" placeholder="Enter Product Discount"
                                            value="{{ !empty($product->id) ? $product->product_discount : old('product_discount') }}">
                                    </div>
                                    <!-- /.form-group -->
                                    
                                    <div class="form-group">
                                        <label for="product_weight">Product Weight</label>
                                        <input type="text" class="form-control" name="product_weight" id="product_weight"
                                            placeholder="Enter Product Weight"
                                            value="{{ !empty($product->id) ? $product->product_weight : old('product_weight') }}">
                                    </div>

                                </div>

                                <div class="col-12 col-sm-6">
                                    
                                    <div class="form-group">
                                        <label for="fabric">Fabrics</label>
                                        <select name="fabric" id="fabric" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>

                                            @foreach ($fabrics as $fabric)
                                                <option value={{ $fabric['key'] }} 
                                                {{ $product->fabric == $fabric['key'] ? 'selected' : '' }}>{{ $fabric['val'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" id="meta_title"
                                            placeholder="Enter Meta Title"
                                            value="{{ !empty($product->id) ? $product->meta_title : old('meta_title') }}">
                                    </div>
                                    
                                </div>

                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label>Sleeves</label>
                                        <select name="sleeve" id="sleeve" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>

                                            @foreach ($sleeves as $sleeve)
                                                <option value={{ $sleeve['key'] }} 
                                                {{ $product->sleeve == $sleeve['key'] ? 'selected' : '' }}>{{ $sleeve['val'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Patterns</label>
                                        <select name="pattern" id="pattern" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>

                                            @foreach ($patterns as $pattern)
                                                <option value={{ $pattern['key'] }} 
                                                {{ $product->pattern == $pattern['key'] ? 'selected' : '' }} >{{ $pattern['val'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                     
                                </div>

                                <div class="col-12 col-sm-6">
                                    
                                    <div class="form-group">
                                        <label>Occasions</label>
                                        <select name="occasion" id="occasion" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>

                                            @foreach ($occasions as $occasion)
                                                <option value={{ $occasion['key'] }}
                                                {{ $product->occasion == $occasion['key'] ? 'selected' : '' }}>{{ $occasion['val'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                    <div class="form-group">
                                        <label for="wash_care">Fits</label>
                                        <select name="fit" id="fit" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>

                                            @foreach ($fits as $fit)
                                                <option value={{ $fit['key'] }} 
                                                {{ $product->fit == $fit['key'] ? 'selected' : '' }}>{{ $fit['val'] }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <!-- /.col -->

                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label>Product Description</label>
                                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Enter Description">{{ !empty($product->id) ? $product->description : old('description') }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <textarea class="form-control" rows="3" name="meta_keywords" id="meta_keywords"
                                            placeholder="Enter Keywords...">{{ !empty($product->id) ? $product->meta_keywords : old('meta_keywords') }}</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->

                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label for="wash_care">Wash Care</label>
                                        <textarea class="form-control" rows="3" name="wash_care" id="wash_care"
                                            placeholder="Enter Wash Care">{{ !empty($product->id) ? $product->wash_care : old('wash_care') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control" rows="3" name="meta_description" id="meta_description"
                                            placeholder="Enter Description...">{{ !empty($product->id) ? $product->meta_description : old('meta_description') }}</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="form-group">
                                    <label for="is_featured">Featured Item</label>
                                        <input type="checkbox" name="is_featured" id="is_featured"
                                            value="Yes" @if (!empty($product->is_featured) && $product->is_featured == "Yes")
                                                checked 
                                             @endif>
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

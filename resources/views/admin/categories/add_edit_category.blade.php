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
                            <li class="breadcrumb-item"><a href="{{ url('admin/categories') }}">Categories</a></li>
                            <li class="breadcrumb-item active">Category Form</li>
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
                <form id="categoryForm" name="categoryForm" method="POST"
                    action="{{ empty($category->id) ? url('admin/add-edit-category') : url('admin/add-edit-category/' . $category->id) }}"
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
                                        <label for="category_name">Category Name</label>
                                        <input type="text" class="form-control" name="category_name" id="category_name"
                                            placeholder="Enter Category Name"
                                            value="{{ !empty($category->id) ? $category->category_name : old('category_name') }}">
                                    </div>
                                    <div id="appendCategoriesLevel">
                                        @include('admin.categories.append_categories_level')
                                    </div>

                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Section</label>
                                        <select name="section_id" id="section_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected">Select</option>

                                            @foreach ($sections as $section)
                                                <option value={{ $section->id }}
                                                    {{ $category->section_id == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="category_image">Category Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="category_image"
                                                    id="category_image">
                                                <label class="custom-file-label" for="category_image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                        @if (!empty($category->category_image))
                                            <div>
                                                <img style="width: 80px; margin-top:5px;"
                                                    src="{{ asset('images/admin/category_images/' . $category->category_image) }}">
                                                &nbsp;
                                                {{-- <a href="{{ url('admin/delete-category-image/' . $category->id) }}">Delete
                                                    Image</a> --}}
                                                <a href="javascript:void(0)" class="confirmDelete" record='category-image' recordid='{{$category->id}}'>Delete
                                                    Image</a>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="category_discount">Category Discount</label>
                                        <input type="text" class="form-control" name="category_discount"
                                            id="category_discount" placeholder="Enter Category Discount"
                                            value="{{ !empty($category->id) ? $category->category_discount : old('category_discount') }}">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Category Description</label>
                                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Enter Description">{{ !empty($category->id) ? $category->description : old('description') }}</textarea>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="url">Category URL</label>
                                        <input type="text" class="form-control" name="url" id="url"
                                            placeholder="Enter Category Url"
                                            value="{{ !empty($category->id) ? $category->url : old('url') }}">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <textarea class="form-control" rows="3" name="meta_title" id="meta_title" placeholder="Enter Meta Title">{{ !empty($category->id) ? $category->meta_title : old('meta_title') }}</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control" rows="3" name="meta_description" id="meta_description"
                                            placeholder="Enter Description...">{{ !empty($category->id) ? $category->meta_description : old('meta_description') }}</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <textarea class="form-control" rows="3" name="meta_keywords" id="meta_keywords"
                                            placeholder="Enter Keywords...">{{ !empty($category->id) ? $category->meta_keywords : old('meta_keywords') }}</textarea>
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

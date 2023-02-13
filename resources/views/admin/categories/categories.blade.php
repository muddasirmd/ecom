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
              <li class="breadcrumb-item active">Categories</li>
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
                <h3 class="card-title">Categories</h3>
                <a href="{{ url('admin/add-edit-category') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display:inline-block">
                    Add Category</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="categories" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Parent Category</th>
                    <th>Section</th>
                    <th>Url</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($categories as $category)
                        
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->parentCategory ? $category->parentCategory->category_name : 'Root' }}</td>
                            <td>{{ $category->section->name }}</td>
                            <td>{{ $category->url }}</td>
                            <td>
                                @if ($category->status == 1)
                                    <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{$category->id}}" 
                                      category_id='{{$category->id}}'>Active</a>
                                @else
                                    <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{$category->id}}" 
                                      category_id='{{$category->id}}'>Inactive</a>
                                @endif
                            </td>
                            <td><a href="{{ url('admin/add-edit-category/'.$category->id) }}">Edit</a></td>
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
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
              <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title">Products</h3>
                <a href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display:inline-block">
                    Add Product</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product)
                        
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->section->name }}</td>
                            <td>{{ $product->category->category_name }}</td>
                            <td>
                              @if (!empty($product->product_image) && file_exists('images/admin_images/product_images/small/'.$product->product_image))
                                <img style="width: 100px" src="{{ asset('images/admin_images/product_images/small/'.$product->product_image) }}">
                              @else
                                <img style="width: 100px" src="{{ asset('images/admin_images/no_image.png') }}">
                              @endif
                              </td>
                            <td>{{ $product->product_price }}</td>
                            <td>
                                @if ($product->status == 1)
                                    <a href="javascript:void(0)" class="updateProductStatus" id="product-{{$product->id}}" 
                                      product_id='{{$product->id}}'>Active</a>
                                @else
                                    <a href="javascript:void(0)" class="updateProductStatus" id="product-{{$product->id}}" 
                                      product_id='{{$product->id}}'>Inactive</a>
                                @endif
                            </td>
                            <td>
                              <a title="Add/Edit Attributes" href="{{ url('admin/add-product-attributes/'.$product->id) }}"><i class="fas fa-plus"></i></a>
                              &nbsp;&nbsp;
                              <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$product->id) }}"><i class="fas fa-edit"></i></a>
                              &nbsp;&nbsp;
                            
                              <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record='product' recordid='{{$product->id}}'><i class="fas fa-trash"></i></a>
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
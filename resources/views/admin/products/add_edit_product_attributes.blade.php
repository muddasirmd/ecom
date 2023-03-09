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
                            <li class="breadcrumb-item active">Product Attributes Form</li>
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
                <form id="addAttributeForm" name="addAttributeForm" method="POST"
                    action="{{ empty($product->id) ? url('admin/add-product-attributes') : url('admin/add-product-attributes/' . $product->id) }}">
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
                                        
                                        @if (!empty($product->product_image) && file_exists('images/admin_images/product_images/small/'.$product->product_image))
                                            <div>
                                                <img style="width: 100px; margin-top:5px;"
                                                    src="{{ asset('images/admin_images/product_images/small/' . $product->product_image) }}">
                                            </div>
                                        @else
                                            <img style="width: 80px; margin-top:5px;" src="{{ asset('images/admin_images/no_image.png') }}">
                                        @endif
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="field_wrapper">
                                            
                                            <div>
                                                <input type="text" name="size[]" value="" style="width:120px" placeholder="Size"/>
                                                <input type="text" name="sku[]" value="" style="width:120px" placeholder="SKU"/>
                                                <input type="number" name="price[]" value="" style="width:120px" placeholder="Price"/>
                                                <input type="number" name="stock[]" value="" style="width:120px" placeholder="Stock"/>
                                                <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                           
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Attributes</button>
                        </div>
                    </div>
                </form>

                
                <div class="card">
                    <div class="card-header">
                      <h2 class="card-title">Added Product Attributes</h3>
                    </div>
                    <form id="editAttributeForm" name="editAttributeForm" method="POST"
                    action="{{ empty($product->id) ? url('admin/edit-product-attributes') : url('admin/edit-product-attributes/' . $product->id) }}">
                    @csrf
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                            <th>Size</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($product->productAttributes as $attr)
                                <tr>
                                    <input type="hidden" name="attrId[]" value="{{ $attr->id }}">
                                    <td>{{ $attr->size }}</td>
                                    <td>{{ $attr->sku }}</td>
                                    <td><input type="number" name="price[]" value="{{ $attr->price }}"></td>
                                    <td><input type="number" name="stock[]" value="{{ $attr->stock }}"></td>
                                    <td>                                  
                                        @if ($attr->status == 1)
                                            <a href="javascript:void(0)" class="updateProductAttributeStatus" id="product-attribute-{{$attr->id}}" 
                                            product_attribute_id='{{$attr->id}}'>Active</a>
                                        @else
                                            <a href="javascript:void(0)" class="updateProductAttributeStatus" id="product-attribute-{{$attr->id}}" 
                                            product_attribute_id='{{$attr->id}}'>Inactive</a>
                                        @endif
                                        &nbsp;&nbsp;
                                        <a title="Delete Attribute" href="javascript:void(0)" class="confirmDelete" record='product-attribute' recordid='{{$attr->id}}'><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Edit Attributes</button>
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
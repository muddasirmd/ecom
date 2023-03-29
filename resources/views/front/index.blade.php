@extends('layouts.front.front_layout')
@section('content')

<div class="span9">
    <div class="well well-small">
        <h4>Featured Products <small class="pull-right">{{ $featured_products_count }} featured products</small></h4>
        <div class="row-fluid">
            <div id="featured" class=" @if($featured_products_count > 4) carousel slide @endif">

                <div class="carousel-inner">

                    @foreach ($featured_products as $key => $products)
                    
                        <div class="item @if($key == 1) active @endif">
                            <ul class="thumbnails">
                                @foreach ($products as $product)
                                    <li class="span3">
                                        <div class="thumbnail">
                                            <i class="tag"></i>
                                            @php
                                                $file_path = 'images/admin/product_images/small/'. $product->product_image;
                                            @endphp
                                            @if (!empty($product->product_image) && file_exists($file_path))
                                                <a href="product_details.html"><img src="{{ asset($file_path) }}" alt=""></a>  
                                            @else
                                                <a href="product_details.html"><img src="{{ asset('images/front/no_image.png') }}" alt=""></a>  
                                            @endif
                                            
                                            <div class="caption">
                                                <h5>{{ strlen($product->product_name) > 30 ? substr($product->product_name,0 , 30)."..." : $product->product_name }}</h5>
                                                <h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.{{ $product->product_price }}</span></h4>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    
                    @endforeach
                    
                </div>
                <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featured" data-slide="next">›</a>
            </div>
        </div>
    </div>
    <h4>Latest Products </h4>
    <ul class="thumbnails">
        @foreach ($latest_products as $product)
            <li class="span3">
                <div class="thumbnail">

                    @php
                        $file_path = 'images/admin/product_images/small/'. $product->product_image;
                    @endphp
                    @if (!empty($product->product_image) && file_exists($file_path))
                        <a href="product_details.html"><img style="max-width: 150px; max-height: 170px;" src="{{ asset($file_path) }}" alt=""></a>  
                    @else
                        <a href="product_details.html"><img style="max-width: 150px; max-height: 170px;" src="{{ asset('images/front/no_image.png') }}" alt=""></a>  
                    @endif

                    <div class="caption">
                        <h5>{{ strlen($product->product_name) > 30 ? substr($product->product_name,0 , 30)."..." : $product->product_name }}</h5>
                        <p>{{ $product->product_code }} ({{$product->product_color }})</p>
                        
                        <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{ $product->product_price }}</a></h4>
                    </div>
                </div>
            </li>
        @endforeach
        
        
    </ul>
</div>

@endsection
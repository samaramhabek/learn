
@extends('layout.master')
@section('content')

    <div class="container">
        <form  action="{{route('currency.store')}}" method="post" >
            @csrf
     <select class="nav-link"  name=currency_Code onchange="this.form.submit()">
     
   <option value="USD" @selected('USD'==session('currency_code'))>$USD</option>
   <option value="EUR"@selected('EUR'==session('currency_code'))>EUR</option>
   <option value="ILS" @selected('ILS'==session('currency_code'))>ILS</option>
   <option value="SYR" @selected('SYR'==session('currency_code'))>SYR</option>
   
   </select>
     </form>
        <section class="hero pb-3 bg-cover bg-center d-flex align-items-center"
            style="background: url(img/hero-banner-alt.jpg)">
            <div class="container py-5">
                <div class="row px-4 px-lg-5">
                    <div class="col-lg-6">
                        <p class="text-muted small text-uppercase mb-2">New Inspiration 2020</p>
                        <h1 class="h2 text-uppercase mb-3">20% off on new season</h1><a class="btn btn-dark"
                            href="shop.html">Browse collections</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- CATEGORIES SECTION-->
        <section class="pt-5">
            <header class="text-center">
                <p class="small text-muted small text-uppercase mb-1">Carefully created collections</p>
                <h2 class="h5 text-uppercase mb-4">Browse our categories</h2>
            </header>
            {{-- @foreach ($categories as $category ) --}}
                
            
            <div class="row">
          
                @foreach ( $imagescat as $imagecat)
            
                    
                <div class="col-md-4"><a class="category-item" href="shop.html"><img class="img-fluid"
                            src="{{asset('imagesproduct/' . $imagecat->image)}}" alt="" /><strong
                            class="category-item-title">{{$imagecat->category->name}}</strong></a>
                </div>
              
                {{-- @endforeach --}}
                
               
            @endforeach
            </div>
            
        </section>
        <!-- TRENDING PRODUCTS-->
        <section class="py-5">
            <header>
                <p class="small text-muted small text-uppercase mb-1">Made the hard way</p>
                <h2 class="h5 text-uppercase mb-4">Top trending products</h2>
            </header>
            <div class="row">
                <!-- PRODUCT-->
               
                   
                @foreach ($products as  $product )

                <div class="col-xl-3 col-lg-4 col-sm-6">
                  
                    <div class="product text-center">
                       
                        <div class="position-relative mb-3">
                            @if ($product->imagesproduct->isNotEmpty())
                            <div class="badge text-white bg-"></div><a class="d-block" href="detail.html"><img
                                    class="img-fluid w-100" src="{{ asset('imagesproduct/' . $product->imagesproduct()->first()->image) }}" alt="..."></a>
                            <div class="product-overlay">
                                <ul class="mb-0 list-inline">
                                    <form method="post" action="{{route('addCart',$product->id)}}">
                                        @csrf
                                        <input type="text" name="product_id" value="{{$product->id}}" style="display: none">
                                        <label >quantity</label>
                        <input class="form-control ml-2" type="number" name="quantity" id="quantity">
                    
                                    <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark"
                                            href="#!"><i class="far fa-heart"></i></a></li>
                                   

                                                 {{-- الطريقة التانية عبر رابط ال href a --}}
                                            {{-- <li class="list-inline-item m-0 p-0"><a href="{{route('addCart',$product->id)}}" class="btn btn-sm btn-dark"type="submit" >Add
                                                to cart</a></li> --}}


                                            <li class="list-inline-item m-0 p-0"><button class="btn btn-sm btn-dark"type="submit" >Add
                                            to cart</button></li>
                                    <li class="list-inline-item me-0"><a class="btn btn-sm btn-outline-dark"
                                            href="#productView" data-bs-toggle="modal"><i class="fas fa-expand"></i></a>
                                    </li>
                                </ul>
                            </div>
                         
                        </div>
                        
                        <h6> <a class="reset-anchor" href="{{route('product.show',$product->id)}}">{{$product->name}}</a></h6>
                        <p class="small text-muted">{{ App\Helpers\currency::format($product->price)}}</p>
                    
                        
                    </div>
                </form>
                    @else
                    <p>No image available</p>
                @endif
                   
                </div>
              
                @endforeach
                <!-- PRODUCT-->
                
                <!-- PRODUCT-->
             
                <!-- PRODUCT-->
                
                <!-- PRODUCT-->
              
                <!-- PRODUCT-->
             
                <!-- PRODUCT-->
                
                <!-- PRODUCT-->
           
        </section>
        <!-- SERVICES-->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row text-center gy-3">
                    <div class="col-lg-4">
                        <div class="d-inline-block">
                            <div class="d-flex align-items-end">
                                <svg class="svg-icon svg-icon-big svg-icon-light">
                                    <use xlink:href="#delivery-time-1"> </use>
                                </svg>
                                <div class="text-start ms-3">
                                    <h6 class="text-uppercase mb-1">Free shipping</h6>
                                    <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-inline-block">
                            <div class="d-flex align-items-end">
                                <svg class="svg-icon svg-icon-big svg-icon-light">
                                    <use xlink:href="#helpline-24h-1"> </use>
                                </svg>
                                <div class="text-start ms-3">
                                    <h6 class="text-uppercase mb-1">24 x 7 service</h6>
                                    <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-inline-block">
                            <div class="d-flex align-items-end">
                                <svg class="svg-icon svg-icon-big svg-icon-light">
                                    <use xlink:href="#label-tag-1"> </use>
                                </svg>
                                <div class="text-start ms-3">
                                    <h6 class="text-uppercase mb-1">Festivaloffers</h6>
                                    <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- NEWSLETTER-->
        <section class="py-5">
            <div class="container p-0">
                <div class="row gy-3">
                    <div class="col-lg-6">
                        <h5 class="text-uppercase">Let's be friends!</h5>
                        <p class="text-sm text-muted mb-0">Nisi nisi tempor consequat laboris nisi.</p>
                    </div>
                    <div class="col-lg-6">
                        <form action="#">
                            <div class="input-group">
                                <input class="form-control form-control-lg" type="email"
                                    placeholder="Enter your email address" aria-describedby="button-addon2">
                                <button class="btn btn-dark" id="button-addon2" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<script>


    </script>

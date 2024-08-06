@extends('layouts.public')

@section('content')
<main class="main">
    <div class="page-content mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                <!-- Showing <span>9 of {{$products->total()}}</span> Products -->
                            </div>
                        </div>
                    </div>
                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            <!-- Product -->
                            @foreach ($products as $product)
                            <div class="col-4">
                                <div class="product product-7 text-center">
                                    <figure class="product-media">
                                        <a href="{{route('public.product.detail',$product->slug)}}">
                                            <img src="{{$product->image_thumbnail}}" alt="Product image" class="product-image product-thumbnail">
                                        </a>
                                        <div class="product-action">
                                            <a href="{{route('public.product.detail',$product->slug)}}" class="btn-product btn-cart"><span>add to cart</span></a>
                                        </div>
                                    </figure>

                                    <div class="product-body">
                                        <div class="product-cat">
                                            <a href="{{route('public.product.detail',$product->slug)}}">{{$product->catalogue->name}}</a>
                                        </div>
                                        <h3 class="product-title"><a href="{{route('public.product.detail',$product->slug)}}">{{$product->name}}</a></h3>

                                        <div class="product-price">
                                            <span class="new-price">Now {{$product->productVariants->min('price_sale')}} $</span>
                                            <span class="old-price">Was {{$product->productVariants->min('price_regular')}} $</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">

                            <li class="page-item {{ $curPage <= 1 ? 'disabled' : '' }}">
                                <a class="page-link page-link-prev" href="{{$curPath}}?page={{$curPage < 1 ? $curPage : $curPage - 1}}" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                </a>
                            </li>
                            @foreach ($pageArray as $key => $page)
                            <li class="page-item {{$page == $curPage ? 'active' : ''}}" aria-current="page">
                                <a class="page-link" href="{{$curPath}}?page={{ $page }}">{{ $page }}</a>
                            </li>
                            @endforeach
                            <li class="page-item-total">of {{$products->lastPage()}}</li>
                            <li class="page-item {{ $curPage >= $products->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link page-link-next" href="{{$curPath}}?page={{$curPage > $products->lastPage() ? $curPage : $curPage + 1}}" aria-label="Next">
                                    Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Filter -->
                <aside class="col-lg-3 order-lg-first">
                    <form class="sidebar sidebar-shop" method="get">
                        <div class="widget widget-clean d-flex justify-content-between pe-5">
                            <button type="button" class="btn btn-outline-secondary rounded p-1" style="width: 80px; min-width:50px"
                                onclick="window.location.href=`{{route('public.allProduct')}}`"
                                >Reset
                            </button>
                            <button type="submit" class="btn btn-outline-success rounded p-1" style="width: 80px; min-width:50px">Filter</button>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    Catalogue
                                </a>
                            </h3>

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count" id="container-catalogue">
                                        @foreach ($catalogues as $key => $catalogue)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" 
                                                    name="catalogue[]" data-catalogue="{{ $catalogue->name }}" 
                                                    id="catalogue-{{$key}}" 
                                                    value="{{$catalogue->id}}"
                                                    @if (in_array($catalogue->id, $listCatalogueParams))
                                                        checked
                                                    @endif
                                                >
                                                <label class="custom-control-label" for="catalogue-{{$key}}">{{ $catalogue->name }}</label>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                    Brand
                                </a>
                            </h3>

                            <div class="collapse show" id="widget-4">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count" id="container-catalogue">
                                        @foreach ($brands as $key => $brand)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="brand[]" class="custom-control-input" 
                                                    data-brand="{{ $brand->name }}" 
                                                    id="brand-{{$key}}" 
                                                    value="{{$brand->id}}"
                                                    @if (in_array($brand->id, $listBrandParams))
                                                        checked
                                                    @endif
                                                >
                                                <label class="custom-control-label" for="brand-{{$key}}">{{ $brand->name }}</label>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </aside>
            </div>
        </div>
    </div>
</main>
@endsection
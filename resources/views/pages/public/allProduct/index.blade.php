@extends('layouts.public')

@section('content')
<main class="main">
    <div class="page-header text-center">
        <div class="container">
            <h1 class="page-title">Fashion Shop<span>All products</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <div class="page-content mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                Showing <span>9 of {{$products->total()}}</span> Products
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-left -->

                        <div class="toolbox-right">
                            <div class="toolbox-sort">
                                <label for="sortby">Sort by:</label>
                                <div class="select-custom">
                                    <select name="sortby" id="sortby" class="form-control">
                                        <option value="popularity" selected="selected">Most Popular</option>
                                        <option value="date">Date</option>
                                    </select>
                                </div>
                            </div><!-- End .toolbox-sort -->
                        </div><!-- End .toolbox-right -->
                    </div><!-- End .toolbox -->
                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            @foreach ($products as $product)
                            <div class="col-6 col-md-4 col-lg-4">
                                <div class="product product-7 text-center">
                                    <figure class="product-media">
                                        <span class="product-label label-new">New</span>
                                        <a href="{{route('public.product.detail', $product->slug)}}">
                                            <img src="{{asset($product->image_thumbnail)}}" alt="Product image thumbnail" class="product-image product-thumbnail">
                                        </a>
                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                        </div><!-- End .product-action -->
                                    </figure><!-- End .product-media -->

                                    <div class="product-body">
                                        <div class="product-cat">
                                            <a href="#">{{ $product->catalogue_name }}</a>
                                        </div><!-- End .product-cat -->
                                        <h3 class="product-title">
                                            <a href="{{route('public.product.detail', $product->slug)}}">
                                                {{ $product->name }}
                                            </a>
                                        </h3><!-- End .product-title -->
                                        <div class="product-price">
                                            {{ $product->price_regular }}
                                        </div><!-- End .product-price -->
                                    </div><!-- End .product-body -->
                                </div><!-- End .product -->
                            </div><!-- End .col-sm-6 col-lg-4 -->
                            @endforeach
                        </div><!-- End .row -->
                    </div><!-- End .products -->
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
                </div><!-- End .col-lg-9 -->
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label>Filters:</label>
                            <a href="#" class="sidebar-filter-clear">Clean All</a>
                        </div><!-- End .widget widget-clean -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    Catalogue
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count" id="container-catalogue">
                                        @foreach ($catalogues as $key => $catalogue)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-catalogue="{{ $catalogue->name }}" id="cat-{{$key}}">
                                                <label class="custom-control-label" for="cat-{{$key}}">{{ $catalogue->name }}</label>
                                            </div>
                                            <!-- End .custom-checkbox -->
                                            <span class="item-count">{{ $catalogue->products_count  }}</span>
                                        </div>
                                        <!-- End .filter-item -->
                                        @endforeach
                                        <div id="additional-catalogues"></div>
                                        @if ($totalCatalogues > 5)
                                        <div class="filter-item d-flex justify-content-center">
                                            <p class="" id="show-more-catalogue" style="cursor: pointer;" onclick="showMoreCatalogues(routeCatalogueShowMore, '#additional-catalogues', this)">
                                                Show more
                                            </p>
                                        </div>
                                        @endif
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                    Size
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-2">
                                <div class="widget-body">
                                    <div class="filter-items">
                                        @foreach ($typeSize as $key => $size)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-size="{{$size->size}}" id="size-{{$key}}">
                                                <label class="custom-control-label" for="size-{{$key}}">{{$size->size}}</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->
                                        @endforeach
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                    Brand
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-4">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count" id="container-catalogue">
                                        @foreach ($brands as $key => $brand)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-brand="{{ $brand->name }}" id="cat-{{$key}}">
                                                <label class="custom-control-label" for="cat-{{$key}}">{{ $brand->name }}</label>
                                            </div>
                                            <!-- End .custom-checkbox -->
                                            <span class="item-count">{{ $brand->products_count }}</span>
                                        </div>
                                        <!-- End .filter-item -->
                                        @endforeach
                                        <div id="additional-brands"></div>
                                        @if ($totalBrands > 5)
                                        <div class="filter-item d-flex justify-content-center">
                                            <p class="" id="show-more-brand" style="cursor: pointer;" onclick="showMoreBrands(routeBrandShowMore, '#additional-brands', this)">Show more</p>
                                        </div>
                                        @endif
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

<!-- config scripts -->
<script>
    const routeCatalogueShowMore = '{{ $showMoreCatalogues }}';
    const routeBrandShowMore = '{{ $showMoreBrands }}';
</script>

<!-- Handle scripts -->
<script>
    // Create closure function
    function createShowMore() {
        let html = '';
        let offset = 5;
        return async function showMore(route, container, btn) {
            const additionalContainer = document.querySelector(container);

            loading().on();
            try {
                const response = await fetch(`${route}?offset=${offset}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                const result = await response.json();
                if (result.success) {
                    result.data.forEach((item, index) => {
                        html += `
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" data-catalogue="${item.name}" id="cat-${offset + index}">
                                <label class="custom-control-label" for="cat-${offset + index}">${item.name}</label>
                            </div>
                            <!-- End .custom-checkbox -->
                            <span class="item-count">${item.products_count}</span>
                        </div>
                        <!-- End .filter-item -->
                        `;
                    });
                    additionalContainer.innerHTML = html;
                    offset += 5;

                } else {
                    btn.style.display = 'none';
                }
            } catch (error) {
                console.log(error);
            } finally {
                loading().off();
            }
        }
    }
    
    // Create show more function
    const showMoreCatalogues = createShowMore();
    const showMoreBrands = createShowMore();
</script>
@endsection

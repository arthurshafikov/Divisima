<!-- Product filter section -->
<section class="product-filter-section loadTopSellingProducts" data-action="{{ route('getTopSellingProducts') }}">
    <div class="container">
        <div class="preloader active">
			<div class="loader"></div>
		</div>	
        <div class="section-title">
            <h2>BROWSE TOP SELLING PRODUCTS</h2>
        </div>
        <ul class="product-filter-menu">
            <li class="category-select"><a href="#" class="active">All</a></li>
            @foreach($categories as $category)
                <li class="category-select"><a href="#" data-cat-id="{{ $category->id }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
        <div class="row top-products">
            
        </div>
        <div class="text-center pt-5">
            <a href="{{ route('shop') }}" class="site-btn sb-line sb-dark" id="top-selling-load">MORE</a>
        </div>
    </div>
</section>
<!-- Product filter section end -->
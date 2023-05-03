@include('header');
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Wishlist<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
        <div id="wishlist-page-success-message" class="d-none">
            <div class="bg-success text-white p-3">
                Product Removed from Wishlist.
            </div>
        </div>
            <table class="table table-wishlist table-mobile">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($wishlists as $wishlist)
                    <tr>
                        <td class="product-col">
                            <div class="product">
                                <figure class="product-media">
                                    <a href="/product/{{ $wishlist->product->slug }}">
                                        <img src="{{ asset('storage/' . $wishlist->product->thumbnail) }}" alt="{{ $wishlist->product->title }}">
                                    </a>
                                </figure>

                                <h3 class="product-title">
                                    <a href="/product/{{ $wishlist->product->slug }}">{{ $wishlist->product->title }}</a>
                                </h3><!-- End .product-title -->
                            </div><!-- End .product -->
                        </td>
                        <td class="price-col">${{ $wishlist->product->price }}</td>
                        <td class="stock-col">
                            @if ($wishlist->product->stock > 0)
                                <span class="in-stock">In stock</span>
                            @else
                                <span class="out-of-stock">Out of stock</span>
                            @endif
                        </td>
                        <td class="action-col">
                            @if ($wishlist->product->stock > 0)
                                <button class="btn btn-block btn-outline-primary-2"><i class="icon-cart-plus"></i>Add to Cart</button>
                            @else
                                <button class="btn btn-block btn-outline-primary-2 disabled">Out of Stock</button>
                            @endif
                        </td>
                        <td class="remove-col">
                            <form method="POST" action="{{ route('wishlists.destroy', $wishlist->id) }}" class="wishlist-remove-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
                                <button type="submit" class="btn-remove btn-wishlist-remove"><i class="icon-close"></i></button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table><!-- End .table table-wishlist -->
            <div class="wishlist-share">
                <div class="social-icons social-icons-sm mb-2">
                    <label class="social-label">Share on:</label>
                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                    <a href="#" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                </div><!-- End .soial-icons -->
            </div><!-- End .wishlist-share -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@include('footer');
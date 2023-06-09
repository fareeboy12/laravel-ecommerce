@include('header');
    <main class="main">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Checkout<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    <div class="checkout-discount">
                        <form action="{{ route('apply-coupon') }}" method="post">
                            @csrf
                            <input type="text" class="form-control" required id="checkout-discount-input" name="coupon_code">
                            <label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
                            <button type="submit" class="btn btn-primary d-inline ml-2">Apply</button>
                        </form>
                    </div><!-- End .checkout-discount -->
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>First Name *</label>
                                            <input type="text" name="first_name" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-6">
                                            <label>Last Name *</label>
                                            <input type="text" name="last_name" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->

                                    <label>Company Name (Optional)</label>
                                    <input type="text" name="company" class="form-control">

                                    <label>Country *</label>
                                    <input type="text" name="country" class="form-control" required>

                                    <label>Street address *</label>
                                    <input type="text" name="address1" class="form-control" placeholder="House number and Street name" required>
                                    <input type="text" name="address2" class="form-control" placeholder="Appartments, suite, unit etc ..." required>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Town / City *</label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-6">
                                            <label>State / County *</label>
                                            <input type="text" name="state" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Postcode / ZIP *</label>
                                            <input type="text" name="postcode" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-6">
                                            <label>Phone *</label>
                                            <input type="tel" name="phone" class="form-control" required>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->

                                    <label>Email address *</label>
                                    <input type="email" name="email" class="form-control" required>

                                    <label>Order notes (optional)</label>
                                    <textarea class="form-control" name="notes" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                                    <input type="hidden" name="payment_method" value="direct_bank_transfer" />
                            </div><!-- End .col-lg-9 -->
                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Products</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($cart['cartItems'] as $item)
                                            <tr>
                                                <td><a href="/product/{{$item->product->slug}}/">{{ $item->product->title }}</a></td>
                                                <td>${{ $item->quantity * $item->product->price }}</td>
                                            </tr>
                                            @endforeach

                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td>${{ $cart['subTotal'] }}</td>
                                            </tr><!-- End .summary-subtotal -->
                                            <tr>
                                                <td>Shipping:</td>
                                                <td>{{ $cart['shippingFee'] == 0 ? 'Free shipping' : '$' . $cart['shippingFee'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Coupon:</td>
                                                <td>-${{ $cart['couponPrice'] }}</td>
                                            </tr>
                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>${{ $cart['totalPrice'] }}</td>
                                            </tr><!-- End .summary-total -->
                                        </tbody>
                                    </table><!-- End .table table-summary -->

                                    <div class="accordion-summary" id="accordion-payment">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cash_on_delivery" checked>
                                            <label class="form-check-label ml-2" for="cod">
                                                Cash On Delivery
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card">
                                            <label class="form-check-label ml-2" for="credit_card">
                                                Credit Card
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Place Order</span>
                                        <span class="btn-hover-text">Proceed to Checkout</span>
                                    </button>
                                </div><!-- End .summary -->
                            </aside><!-- End .col-lg-3 -->
                        </div><!-- End .row -->
                    </form>
                </div><!-- End .container -->
            </div><!-- End .checkout -->
        </div><!-- End .page-content -->
        </main><!-- End .main -->
@include('footer');
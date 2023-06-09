@include('header');
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Account<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <aside class="col-md-4 col-lg-2">
                        <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Orders</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Downloads</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Adresses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}">Sign Out</a>
                            </li>
                        </ul>
                    </aside><!-- End .col-lg-3 -->

                    <div class="col-md-8 col-lg-10">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                <p>Hello <span class="font-weight-normal text-dark">{{ $user->first_name }} {{ $user->last_name }}</span> 
                                <br>
                                From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
                                @if($orders->isEmpty())
                                <p>No order has been made yet.</p>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                                @else
                                    <table class="table table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Title</th>
                                                <th></th>
                                                <th>Price</th>
                                                <th>QTY</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                @php $itemCount = count($order->orderItems); @endphp
                                                @foreach($order->orderItems as $key => $item)
                                                    <tr>
                                                        @if ($key === 0)
                                                            <td rowspan="{{ $itemCount }}">{{ $loop->parent->iteration }}</td>
                                                            <td rowspan="{{ $itemCount }}">{{ $order->order_number }}</td>
                                                            <td rowspan="{{ $itemCount }}">{{ $order->created_at->format('F d, Y \A\t h:i A') }}</td>
                                                            <td rowspan="{{ $itemCount }}">{{ ucfirst($order->order_status) }}</td>
                                                        @endif
                                                        <td><a href="/product/{{ $item->product->slug }}">{{ $item->product->title }}</a></td>
                                                        <td><a href="/product/{{ $item->product->slug }}"><img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->title }}" width="50"></a></td>
                                                        <td>${{ $item->product->price }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>${{ $item->product->price * $item->quantity }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>


                                @endif
                            </div><!-- .End .tab-pane -->

                            <!-- <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
                                <p>No downloads available yet.</p>
                                <a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                            </div> -->
                            <!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
                                <p>The following addresses will be used on the checkout page by default.</p>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

                                                <p>{{ $user->first_name }} {{ $user->last_name }}<br>
                                                {{ $user->address1 }}<br>
                                                {{ $user->address2 }}<br>
                                                {{ $user->phone }}<br>
                                                {{ $user->email }}<br>
                                                <!-- <a href="#">Edit <i class="icon-edit"></i></a></p> -->
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                <form action="{{ route('user.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>First Name *</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-6">
                                            <label>Last Name *</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Address 1 *</label>
                                            <input type="text" class="form-control" name="address1" value="{{ $user->address1 }}" required>
                                        </div><!-- End .col-sm-6 -->

                                        <div class="col-sm-6">
                                            <label>Address 2 *</label>
                                            <input type="text" class="form-control" name="address2" value="{{ $user->address2 }}" required>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->

                                    <label>Phone Number *</label>
                                    <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}" required>

                                    <label>Email address *</label>
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                                    <label>New password (leave blank to leave unchanged)</label>
                                    <input type="password" name="new_password" class="form-control">

                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>SAVE CHANGES</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@include('footer');
@extends('clients.layouts.app')

@section('content')
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart->products as $item)
                                <tr id="row-{{$item->pivot->id}}">
                                    <td class="thumbnail-img">
                                        <a href="#">
                                            <img class="img-fluid" src="{{asset('upload/'. $item->images->first()->url)}}" alt="" />
                                        </a>
                                    </td>
                                    <td class="name-pr">
                                        <a href="#">
                                            {{$item->name}}
                                        </a>
                                    </td>
                                    <td class="price-pr">
                                        <p>$ {{number_format($item->price, 0, '', ',')}}</p>
                                    </td>
                                    <td class="quantity-box">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm  btn-minus btn-update-quantity"
                                                    data-action="{{ route('client.carts.update_product_quantity', $item->pivot->id) }}"
                                                    data-id="{{ $item->pivot->id }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="number" class="form-control form-control-sm text-center p-0"
                                                id="productQuantityInput-{{ $item->pivot->id }}" min="1"
                                                value="{{ $item->pivot->product_quantity }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus btn-update-quantity"
                                                    data-action="{{ route('client.carts.update_product_quantity', $item->pivot->id) }}"
                                                    data-id="{{ $item->pivot->id }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total-pr">
                                        <p id="cartProductPrice-{{$item->pivot->id}}">$ {{number_format($item->price * $item->pivot->product_quantity, 0, '', ',')}}</p>
                                    </td>
                                    <td class="remove-pr">
                                        <button data-action="{{route('client.carts.delete_product', $item->pivot->id)}}" data-id="{{$item->pivot->id}}" id="delete-cart-item"
                                            style="border: none; background-color: #fff;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-6 col-sm-6">
                    @if (session('message'))
                    <h2 class="" style="text-align: center; width:100%; color:red"> {{ session('message') }}</h2>
                    @endif
                    <form action="{{route('carts.apply.coupon')}}" method="post" class="coupon-box">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input name="coupon_code" class="form-control" placeholder="Enter your coupon code" aria-label="Coupon code"
                                type="text">
                            <div class="input-group-append">
                                <button class="btn btn-theme" type="submit">Apply Coupon</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="update-box">
                        <input value="Update Cart" type="submit">
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <h3>Order summary</h3>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold" id="sub-total"> $ {{number_format($totalProductInCart, 0, '', ',')}}</div>
                        </div>
                        {{-- <div class="d-flex">
                            <h4>Discount</h4>
                            <div class="ml-auto font-weight-bold"> $ 40 </div>
                        </div>
                        <hr class="my-1"> --}}
                        <div class="d-flex">
                            <h4>Coupon Discount</h4>
                            <div class="ml-auto font-weight-bold"> $ 10 </div>
                        </div>
                        {{-- <div class="d-flex">
                            <h4>Tax</h4>
                            <div class="ml-auto font-weight-bold"> $ 2 </div>
                        </div> --}}
                        <div class="d-flex">
                            <h4>Shipping Cost</h4>
                            <div class="ml-auto font-weight-bold"> Free </div>
                        </div>
                        <hr>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5"> $ {{number_format($totalProductInCart, 0, '', ',')}} </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="col-12 d-flex shopping-box"><a href="checkout.html" class="ml-auto btn hvr-hover">Checkout</a>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="client/assets/cart/cart.js"></script>
    <script>
        const USDollar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });

         $(document).on(
        "click",
        ".btn-update-quantity",
        _.debounce(function (e) {
            let url = $(this).data("action");
            let id = $(this).data("id");
            let data = {
                _token: '{{ @csrf_token()}}',
                product_quantity: $(`#productQuantityInput-${id}`).val(),
            };
            $.post(url, data, (res) => {
                
                let cartProductId = res.product_cart_id;
                let cart = res.cart;
                $("#productCountCart").text(cart.product_count);
                if (res.remove_product) {
                    $(`#row-${cartProductId}`).remove();
                } else {
                    $(`#cartProductPrice-${cartProductId}`).html(
                        `${USDollar.format(res.cart_product_price)}`
                    );
                }
                
                $("#sub-total").text(`${USDollar.format(cart.total_price)}`);
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "success",
                    showConfirmButton: false,
                    timer: 1000,
                });
            });
        }, 2000)
    );

    $(document).on('click', '#delete-cart-item', function(e) {
        let url = $(this).data("action");
        let data = {
                _token: '{{ @csrf_token()}}',
            };
        confirmDelete()
            .then(function() {
                $.post(url, data, (res) => {
                    console.log("res:", res)
                    let cartProductId = res.product_cart_id;
                    let cart = res.cart;
                    $("#productCountCart").text(cart.product_count);
                    $("#sub-total").html(`${USDollar.format(cart.total_price)}`);
                    $(`#row-${cartProductId}`).remove();
                })

            })

    })

    </script>
@endsection

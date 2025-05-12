@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Wishlist</h2>
        <div class="shopping-cart">
          @if(Cart::instance('wishlist')->content()->count()>0)
            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>
                                <div class="shopping-cart__product-item">
                                    @if ($item->model && $item->model->image)
                                        <img loading="lazy" src="{{ asset('uploads/products/thumbnails/' . $item->model->image) }}" width="120" height="120" alt="{{ $item->name }}" />
                                    @else
                                        <img loading="lazy" src="{{ asset('images/placeholder.png') }}" width="120" height="120" alt="{{ $item->name }}" />
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4>{{ $item->name }}</h4>
                                    @if ($item->model && $item->model->brand)
                                        <ul class="shopping-cart__product-item__options">
                                            <li>Brand: {{ $item->model->brand->name }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__product-price">${{ number_format($item->price, 2) }}</span>
                            </td>
                            <td>
                                <div class="qty-control position-relative">
                                    <input type="number" name="quantity" value="{{ $item->qty }}" min="1" class="qty-control__number text-center" readonly>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__subtotal">${{ number_format($item->price * $item->qty, 2) }}</span>
                            </td>
                            <td>
                            <div class="row">
    <div class="col-6">
        <form method="POST" action="{{route('wishlist.move.to.cart',['rowId'=>$item->rowId])}}">
            @csrf
            <button type="submit" class="btn btn-sm btn-warning">Move to Cart</button>
        </form>
    </div>
    <div class="col-6">
        <form method="POST" action="{{route('wishlist.remove',['rowId'=>$item->rowId])}}" id="remove-item-{{$item->id}}">
            @csrf
            @method('DELETE')
            <a href="javascript:void(0)" class="remove-cart" onclick="document.getElementById('remove-item-{{$item->id}}').submit();">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.259435 8.85506L9.11449 0.259435L10 0.885506L0.885506 9.74057L0 9.11449L8.85506 0.259435Z" />
                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.94404 8.85506L0.0889838 0.974491L0.885506 0.0889838Z" />
                </svg>
            </a>
        </form>
    </div>
</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="cart-table-footer">
                    <form method="POST" action="{{route('wishlist.items.clear')}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light">CLEAR WISHLIST</button>
                    </form>
                </div>
            </div>
            @else
              <div class="row">
                <div class="col-md-12">
                  <p>No item found in your wishlist</p>
                  <a href="{{route('shop.index')}}" class="btn btn-info">Wishlist Now</a>
                </div>
              </div>
            @endif
        </div>
    </section>
</main>
@endsection
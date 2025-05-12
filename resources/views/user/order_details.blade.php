@extends('layouts.app')

@section('content')

<style>
    .table> :not(caption)>tr>th {
      padding: 0.625rem 1.5rem .625rem !important;
      background-color: #6a6e51 !important;
    }

    .table>tr>td {
      padding: 0.625rem 1.5rem .625rem !important;
    }

    .table-bordered> :not(caption)>tr>th,
    .table-bordered> :not(caption)>tr>td {
      border-width: 1px 1px;
      border-color: #6a6e51;
    }

    .table> :not(caption)>tr>td {
      padding: .8rem 1rem !important;
    }
    .bg-success {
      background-color: #40c710 !important;
    }

    .bg-danger {
      background-color: #f44032 !important;
    }

    .bg-warning {
      background-color: #f5d700 !important;
      color: #000;
    }
  </style>
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders Details</h2>
        <div class="row">
          <div class="col-lg-2">
              @include('user.account-nav')
          </div>

          <div class="col-lg-10">
            <div class="wg-box">
                <div class="flex items-center justify-between gap-10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Details</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{route('admin.orders')}}">Back</a>
                </div>
                <div class="table-responsive">
                          @if (Session::has('status'))
                    <p class="alert alert-success">{{Session::get('status')  }}</p>
                @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <td>{{$order->id}}</td>
                                <th>Phone Number</th>
                                <td>{{$order->phone}}</td>
                                <th>Zip Code</th>
                                <td>{{$order->zip}}</td>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{$order->created_at}}</td>
                                <th>Delivered Date</th>
                                <td>{{$order->delivered_date}}</td>
                                <th>Canceled Date</th>
                                <td>{{$order->canceled_date}}</td>
                            </tr>
                            <tr>
                                <th>Order Status</th>
                                <td colspan="5">
                                    @if($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->status == 'canceled')
                                        <span class="badge bg-danger">Canceled</span>
                                    @else
                                        <span class="badge bg-warning">Ordered</span>
                                    @endif
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap-10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Return Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{asset('uploads/products/thumbnails')}}/{{$item->product->image}}" alt="{{$item->product->name}}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{route('shop.product.details', ['product_slug'=>$item->product->slug])}}" target="_blank" class="body-title-2">{{$item->product->name}}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">${{$item->price}}</td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td class="text-center">{{$item->product->SKU}}</td>
                                    <td class="text-center">{{$item->product->category->name}}</td>
                                    <td class="text-center">{{$item->product->brand->name}}</td>
                                    <td class="text-center">{{$item->options}}</td>
                                    <td class="text-center">{{$item->status == 0 ? "No" : "Yes"}}</td>
                                    <td class="text-center">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap-10 wgp-pagination">
                    {{$orderItems->links('pagination::bootstrap-5')}}
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Shipping Address</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>{{ $order->name }}</p>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->locality }}</p>
                        <p>{{ $order->city }}, {{ $order->country }}</p>
                        <p>{{ $order->landmark }}</p>
                        <p>{{ $order->zip }}</p>
                        <br>
                        <p>Mobile: {{ $order->phone }}</p>
                    </div>
                </div>
            </div>
            <div class="wg-box mt-5">
                <h5>Transactions</h5>
                <div class="table-responsive table-transaction">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th>Subtotal</th>
                                <td>${{ number_format($order->subtotal, 2) }}</td>
                                <th>Tax</th>
                                <td>${{ number_format($order->tax, 2) }}</td>
                                <th>Discount</th>
                                <td>${{ number_format($order->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <th>Payment Method</th>
                                <td>{{ optional($transaction)->mode ?? 'N/A' }}</td>
                                <th>Status</th>
                                <td>
                                    @php $status = optional($transaction)->status; @endphp
                                    @if($status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($status === 'decline')
                                        <span class="badge bg-danger">Declined</span>
                                    @elseif($status === 'refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


{{--
            <div class="mg-box mt-5">
                <h5>Update Order</h5>
                <table class="table table-striped table-bordered table-transaction">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>${{ $order->subtotal }}</td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td>${{ $order->tax }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>${{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>${{ $order->total }}</td>
                        </tr>
                        <tr>
                            <th>Payment Mode</th>
                            <td>{{ $transaction->mode }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($transaction)
                                    @if($transaction->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($transaction->status == 'declined')
                                        <span class="badge bg-danger">Declined</span>
                                    @elseif($transaction->status == 'refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                @else
                                    <span class="badge bg-dark">N/A</span>
                                @endif
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($order->status=='ordered')
            <div class="mg-box mt-5">
                <form action="{{ route('user.order.cancel') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button type="button" class="btn btn-danger cancel-order">Canceled Order</button>
                </form>
            </div>

            @endif
          </div> --}}

        </div>
    </section>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.cancel-order').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to cancel this order',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush


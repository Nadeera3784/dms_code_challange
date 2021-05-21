@extends('ui.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
             <div class="card">
                @if(session('cart'))
                <table id="cart" class="table table-hover table-condensed">
                   <thead>
                        <tr>
                            <th style="width:50%">Product</th>
                            <th style="width:10%">Price</th>
                            <th style="width:8%">Quantity</th>
                            <th style="width:22%" class="text-center">Subtotal</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0 ?>
                        @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                                <?php $total += $details['price'] * $details['quantity'] ?>
                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-3 hidden-xs"><img src="{{asset('assets/images/')}}/{{ $details['image'] }}" width="100" height="100" class="img-responsive"/></div>
                                            <div class="col-sm-9">
                                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Price">${{ $details['price'] }}</td>
                                    <td data-th="Quantity">
                                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                                    </td>
                                    <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                                    <td class="actions" data-th="">
                                        <button class="btn btn-primary btn-sm update-cart" data-id="{{ $id }}"><i class="mdi mdi-refresh"></i></button>
                                        <button class="btn btn-dark btn-sm remove-from-cart" data-id="{{ $id }}"><i class="mdi mdi-delete"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Subtotal</td>
                            <td  class="text-center"><strong>{{ '$'.number_format($total, 2) }}</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><a href="{{ url('/') }}" class="btn btn-dark"><i class="mdi  mdi-arrow-left"></i> Continue Shopping</a></td>
                            <td></td>
                            <td>Total</td>
                            <td  class="text-center"><strong>{{ '$'.number_format($total, 2) }}</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><a href="{{ route('checkout') }}" class="btn btn-primary btn-block"><i class="mdi mdi-wallet"></i> Checkout</a></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                @else 
                    <div class="p-5 text-center">
                      <i class="mdi mdi-cart-off mdi-48px"></i>
                     <h2 class="text-center mb-5">Your cart is currently empty!</h2>
                     <a href="{{ url('/') }}" class="btn btn-primary"><i class="mdi  mdi-arrow-left"></i> Return to shop</a>
                    </div>
                @endif
            </div>
       </div>
    </div>
</div>

@endsection


@section('js')

    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>

    <script type="text/javascript">

        $(".update-cart").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: "{{ url('update/cart') }}",
               method: "POST",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            swal({
                  title: "Are you sure?",
                  text: "Are you sure you want to remove this item?",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
            }).then((willDelete) => {
                  if(willDelete) {
                    $.ajax({
                        url: "{{ url('remove/cart') }}",
                        method: "POST",
                        data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                  }
            });
        });

    </script>
@endsection


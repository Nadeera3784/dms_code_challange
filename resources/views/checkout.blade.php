@extends('ui.app')

@section('content')
<div class="container">
<div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">{{ count((array) session('cart')) }}</span>
          </h4>
          <ul class="list-group mb-3">
              <?php $total = 0 ?>
              @if(session('cart'))
              @foreach(session('cart') as $id => $details)
              <?php $total += $details['price'] * $details['quantity'] ?>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                  <div>
                    <h6 class="my-0">{{ $details['name'] }}</h6>
                    <small class="text-muted">${{ $details['price'] }} X {{ $details['quantity'] }}</small>
                  </div>
                  <span class="text-muted">${{ $details['price'] * $details['quantity'] }}</span>
                </li>
              @endforeach
             @endif
            <li class="list-group-item d-flex justify-content-between bg-light" id="codeContainer" style="display: none !important">
              <div class="text-success">
                <h6 class="my-0">Promo code</h6>
                <small id="code"></small>
              </div>
              <span class="text-success" id="code_amount"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Sub Total (USD)</span>
              <strong id="sub_total_pre">{{ number_format($total, 2) }}</strong>
            </li>

            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong id="total_pre">{{ number_format($total, 2) }}</strong>
            </li>
          </ul>

          <form method="post" class="card p-2" id="promoCodeForm">
            <div class="input-group">
              <input type="text" class="form-control" name="code" placeholder="Promo code">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary" id="redeemCode">Redeem</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form method="POST" action="{{route('payment')}}" id="paymentForm" >
             @csrf
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="first_name">First name</label>
                <input type="text" class="form-control required" id="first_name" name="first_name">
                @error('first_name')
                    <span class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label for="last_name">Last name</label>
                <input type="text" class="form-control required" id="last_name" name="last_name">
                @error('last_name')
                    <span class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Email </label>
              <input type="email" class="form-control required" id="email" name="email" placeholder="you@example.com">
              @error('email')
                <span class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control required" id="address" name="address" placeholder="1234 Main St">
              @error('address')
                <span class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite">
              <input type="hidden" id="sub_total" name="sub_total" value="{{ number_format($total, 2) }}">
              <input type="hidden" id="total" name="total" value="{{ number_format($total, 2) }}">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100 required" id="country" name="country">
                  <option value="">Choose...</option>
                  <option value="United States">United States</option>
                </select>
                @error('country')
                <span class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100 required" id="state" name="state">
                  <option value="">Choose...</option>
                  <option value="California">California</option>
                </select>
               @error('state')
                <span class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control required" id="zip" name="zip">
               @error('zip')
                <span class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
              </div>
            </div>

            <div class="row">
            <div class="form-group col-sm-6">
              <label class="js-check box active">
                <input type="radio" name="dostavka" value="option1" checked="">
                <h6 class="title">Delivery</h6>
                <p class="text-muted">We will deliver by DHL Kargo</p>
              </label>
            </div>
            <div class="form-group col-sm-6">
              <label class="js-check box">
                <input type="radio" name="dostavka" value="option1">
                <h6 class="title">Pick-up</h6>
                <p class="text-muted">Come to our office to somewhere </p>
              </label>
            </div>
          </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
          </form>
        </div>
      </div>
</div>

@endsection


@section('js')

    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>

    <script type="text/javascript">
          $("#paymentForm").validate();
          var is_redeemed = false;
          $('#redeemCode').click(function(event){
             event.preventDefault();
             if(is_redeemed){
               swal("Error", "You have already redeemed this code", "warning", {button: false});
             }else{
               var promoCodeForm = $("#promoCodeForm");
                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                $.ajax({
                  url: "{{route('check.coupon')}}",
                  type:'POST',
                  dataType : 'json',
                  data : promoCodeForm.serialize(),
                  success: function(data) {
                      if(data.type == "success"){
                        is_redeemed = true;
                        $('#code').text(data.message.code);  
                        $('#code_amount').text(data.message.discount + '%');
                        $('#codeContainer').show();
                        
                        var subtotal = $('#sub_total_pre').text();  

                        var totalValue = subtotal * ( (100 - data.message.discount) / 100 );

                        $('#total_pre').text(totalValue.toFixed(2));

                        $('#total').val(totalValue.toFixed(2));

                        swal("Congratulation", "Promo code has been added", "success", {button: false});
                      }else{
                        swal("Error", "Something went wrog, please try again later!", "warning", {button: false});
                      }
                  },
                  error : function(error){
                     swal("Error", "Something went wrog, please try again later!", "warning", {button: false});
                  }
                });
             }
          })
    </script>
@endsection


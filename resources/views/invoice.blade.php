@extends('ui.app')

@section('content')

<div class="container invoice-container">
  <header>
  <div class="row align-items-center">
    <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
      <img id="logo" src="{{ asset('assets/images/logo.png') }}" title="invoice" alt="invoice">
    </div>
    <div class="col-sm-5 text-center text-sm-right">
      <h4 class="text-7 mb-0">Invoice</h4>
    </div>
  </div>
  <hr>
  </header>
  
  <main>
  <div class="row">
    <div class="col-sm-6"><strong>Date:</strong> {{Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d')}}</div>
    <div class="col-sm-6 text-sm-right"> <strong>Invoice No:</strong> {{$invoice->invoice_no}}</div>
    
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-6 text-sm-right order-sm-1"> <strong>Pay To:</strong>
      <address>
      Bookshop<br>
      2705 N. Enterprise St<br>
      Orange, CA 92865<br>
      contact@bookshop.com
      </address>
    </div>
    <div class="col-sm-6 order-sm-0"> <strong>Invoiced To:</strong>
      <address>
      {{ucfirst($invoice->first_name)}} {{$invoice->last_name}}<br>
      {{$invoice->address}}<br>
      {{$invoice->zip}} {{$invoice->state}}<br>
      {{$invoice->country}}
      </address>
    </div>
  </div>
  
  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead class="card-header">
          <tr>
            <td class="col-3 border-0"><strong>Product</strong></td>
            <td class="col-2 text-center border-0"><strong>Price</strong></td>
            <td class="col-1 text-center border-0"><strong>QTY</strong></td>
            <td class="col-2 text-right border-0"><strong>Amount</strong></td>
          </tr>
        </thead>
          <tbody>
            @foreach($invoice->items as $item)
            <tr>
              <td class="col-3 border-0">{{$item->product->title}}</td>
              <td class="col-2 text-center border-0">{{ '$'.number_format($item->price, 2) }}</td>
              <td class="col-1 text-center border-0">{{ $item->quantity }}</td>
              <td class="col-2 text-right border-0">{{ '$'.number_format($item->quantity * $item->price, 2) }}</td>
             </tr>
             @endforeach
          </tbody>
            <tfoot class="card-footer">
            <tr>
                <td colspan="3" class="text-right"><strong>Sub Total:</strong></td>
                <td class="text-right">{{ '$'.number_format($invoice->sub_total, 2) }}</td>
            </tr>
            <tr>
              <td colspan="3" class="text-right"><strong>Total:</strong></td>
              <td class="text-right">{{ '$'.number_format($invoice->total, 2) }}</td>
             </tr>
            </tfoot>
        </table>
      </div>
    </div>
  </div>
  </main>
  <!-- Footer -->
  <footer class="text-center mt-4">
  <p class="text-1"><strong>NOTE :</strong> This is computer generated receipt and does not require physical signature.</p>
  <div class="btn-group btn-group-sm d-print-none">
   <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> </div>
  </footer>
</div>

@endsection



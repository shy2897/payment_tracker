@extends('layouts.app_admin')

@section('main_admin')


    <div class="container">
        <div class="container mt-6">
            <div class="row justify-content-end">

              <div class="col-auto">
                <form action="/admin/search_data" method="GET" class="form-inline">
                  <div class="form-group">
                    <input type="text" name="search" class="form-control" value="Search" onfocus="if (this.value=='Search') this.value='';">
                    <button type="submit" class="btn btn-primary font-weight-bold ml-2">Search</button>
                    </br></br></br>
                  </div>
                </form>
              </div>
            </div>
          </div>

        @php
            // Sort the $monthlyData array in descending order based on year and month
            $monthlyData = $monthlyData->sortByDesc(function ($record) {
                return $record->year * 100 + $record->month;
            });
        @endphp
      
        @foreach ($monthlyData as $record)

        <div class="d-flex">
          <h5 class="text-month pr-3">{{ date("F Y", mktime(0, 0, 0, $record->month, 1, $record->year)) }}</h5>
          <a href="{{ route('admin.generatePdf', ['year' => $record->year, 'month' => $record->month]) }}" class="btn btn-sm btn-dark d-inline">Generate PDF</a>
        </div>
              <table class="table table-hover mt-3 rounded">
              <thead class="bg-primary shadow header-text" style="border-radius: 10px;">
                  <tr>
                    <th>Status</th>
                    <th class="fixed-invoice">Invoice No.</th>
                    <th class="fixed-date">Invoice Date</th>
                    <th class="fixed-description">Description</th>
                    <th class="fixed-amount">Amount</th>
                    <th class="fixed-action">Action</th>
                    <th class="fixed-approval">Approval</th>
                  </tr>
              </thead>
              <tbody>

                  @php
                      // Sort the $products array in descending order based on id
                      $products = $products->sortByDesc('invoice_date');
                  @endphp

                  @foreach($products as $product)
                      @if (date("Y", strtotime($product->invoice_date)) == $record->year && date("n", strtotime($product->invoice_date)) == $record->month)
                          <tr class="shadow">
                              <td>
                                <div class="container d-flex align-items-center">
                                  <div class="row justify-content-center align-items-center">
                                      <div class="col-4 text-center p-2">
                                          <div style="width: 10px; height: 10px; background-color: {{ $product->status_color }}; border-radius: 50%;">
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              </td>

                              <td>
                                <b>
                                  <a href="products/{{ $product->id }}/show" class="text-dark">
                                  {{ $product->invoice_no }}</a>
                                </b>
                              </td>

                              <td>{{ date('d/m/Y', strtotime($product->invoice_date)) }}</td>

                              <td>{{ $product->description }}</td>
                              
                              <td> <b>{{ $product->currency }}</b> {{ $product->amount }}</td>
                              
                              <td>
                              
                                  <a href="products/{{ $product->id }}/show"
                                  class="btn btn-outline-info btn-sm shadow">View</a>

                              </td>
                              <td style="width: 175px;">
                                <form action="/products/{{ $product->id }}/approve" method="POST" enctype="multipart/form-data" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm shadow">Approve</button>
                                </form>
                                
                                  <button type="button" class="btn btn-outline-danger btn-sm shadow" data-toggle="modal" data-target="#exampleModal" data-product-id="{{ $product->id }}">
                                      Reject
                                  </button>
                                  
                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Reason for Rejection</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <form id="rejectForm" method="POST" enctype="multipart/form-data">
                                                  @csrf
                                                  <div class="form-group modal-body">
                                                      <input type="hidden" name="product_id" id="product_id" value="">
                                                      <textarea class="form-control" name="remarks" rows="3"></textarea>
                                                      @if($errors->has('remarks'))
                                                          <span class="text-danger">{{ $errors->first('remarks') }}</span>
                                                      @endif
                                                  </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                      <button type="submit" class="btn btn-primary">Submit</button>
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                                  
                                  <script>
                                      $('#exampleModal').on('show.bs.modal', function (event) {
                                          var button = $(event.relatedTarget);
                                          var productId = button.data('product-id');
                                          $('#product_id').val(productId);
                                          var formAction = "/products/" + productId + "/reject";
                                          $('#rejectForm').attr('action', formAction);
                                      });
                                  </script>
                                  
                                
                            </td>
                          </tr>
                      @endif
                  @endforeach
              </tbody>
              </table>
              <br>

      @endforeach
    </div>
    
@endsection
@extends('layouts.test_test')

@section('test_test')
      <div class="">
          <div class="row justify-content-center">
            <div class="col-sm-10">
              <div class="card mt-1 px-4 py-3 shadow rounded-year">
                <form action="/amc/{{ $product->id }}/update" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="row pb-3">
                    <a href="/amc" class="btn btn-outline-primary btn-outline-custom-primary rounded-year col-md-1"><i class="fa-solid fa-arrow-left"></i></a>
                    <h6 class="font-weight-bold pb-2 text-center text-primary col-md-10">General details</h6>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-md-3">
                      <label class="font-weight-bold">Invoice Date:</label>
                      <input type="date" name="invoice_date" id="invoice_date" class="form-control rounded-year" value="{{ old('invoice_date', $product->invoice_date) }}"/>
                      @if($errors->has('invoice_date'))
                          <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                      @endif
                    </div>

                    <div class="dropdown col-md-3 text-center">
                      <br>
                      <select id="sub_category" name="sub_category" class=" btn btn-md btn-dark mb-3 rounded-year mt-2">
                        <option value="{{ old('sub_category', $product->sub_category) }}">{{ old('sub_category', $product->sub_category) }}</option>
      
                      </select>
                      
                    </div>
                    <div class="col-md-2">
                        <label class="font-weight-bold">Invoice Number:</label>
                        <input type="text" name="invoice_no" class="form-control rounded-year" value="{{ old('invoice_no', $product->invoice_no) }}"/>
                        @if($errors->has('invoice_no'))
                            <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                        @endif
                    </div>

                    <div class="col-md-2">
                      <label class="font-weight-bold">Vendor:</label>
                      <input type="text" name="vendor" class="form-control rounded-year" value="{{ old('vendor', $product->vendor) }}"/>
                      @if($errors->has('vendor'))
                          <span class="text-danger">{{ $errors->first('vendor') }}</span>
                      @endif
                    </div>

                  <div class="col-md-2">
                    <label class="font-weight-bold">Units:</label>
                    <input type="text" name="units" class="form-control rounded-year" value="{{ old('units', $product->units) }}"/>
                    @if($errors->has('units'))
                        <span class="text-danger">{{ $errors->first('units') }}</span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-3">
                    <label class="font-weight-bold">Deadline Date:</label>
                    <input type="date" name="deadline_date" class="form-control rounded-year" value="{{ old('deadline_date', $product->deadline_date) }}"/>
                    @if($errors->has('deadline_date'))
                        <span class="text-danger">{{ $errors->first('deadline_date') }}</span>
                    @endif
                  </div>
                  
                  <div class="col-md-3">
                    <label class="font-weight-bold">Description:</label>
                    <textarea  class="form-control rounded-year" name="description" rows="1">{{ old('description', $product->description) }}</textarea>
                    @if($errors->has('description'))
                      <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                  </div>
                
                  <div class="col-md-3">
                    <label class="font-weight-bold">Comment:</label>
                    <textarea  class="form-control rounded-year" name="comment" rows="1">{{ old('comment', $product->comment) }}</textarea>
                    @if($errors->has('comment'))
                      <span class="text-danger">{{ $errors->first('comment') }}</span>
                    @endif
                  </div>
                  <div class="col-md-3">
                    <label class="font-weight-bold">File Upload:</label>
                    <input type="file" name="file" class="form-control rounded-year"/>
                    @if($errors->has('file'))
                      <span class="text-danger">{{ $errors->first('file') }}</span>
                    @endif
                  </div>

                </div>

                  <div class="form-group p-0">
                    <h6 class="font-weight-bold pb-1 text-center text-primary">Payment amount details</h6>
      
                    <div class="form-group row justify-content-center">
                      <div class="dropdown col-md-1 text-center">
                        <br>
                        <select id="currency" name="currency" class=" btn btn-md btn-dark mb-1 rounded-year mt-2">
                            <option value="BTN" {{ $product->currency == 'BTN' ? 'selected' : '' }}>BTN</option>
                          <option value="INR" {{ $product->currency == 'INR' ? 'selected' : '' }}>INR</option>
                          <option value="USD" {{ $product->currency == 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                      </div>
                      <div class="col-md-2">
                          <label class="font-weight-bold">Rate:</label>
                          <input type="text" name="rate" id="rate" class="form-control rounded-year" value="{{ old('rate', $product->rate) }}"/>
                          @if($errors->has('rate'))
                              <span class="text-danger">{{ $errors->first('rate') }}</span>
                          @endif
                      </div>
                  
                      <div class="col-md-2">
                          <label class="font-weight-bold">TDS:</label>
                          <input type="text" name="tds" id="tds" class="form-control rounded-year" value="{{ old('tds', $product->tds) }}"/>
                          @if($errors->has('tds'))
                              <span class="text-danger">{{ $errors->first('tds') }}</span>
                          @endif
                      </div>
                  
                      <div class="col-md-2">
                          <label class="font-weight-bold">AMC:</label>
                          <input type="text" name="amc" id="amc" class="form-control rounded-year" value="{{ old('amc', $product->amc) }}"/>
                          @if($errors->has('amc'))
                              <span class="text-danger">{{ $errors->first('amc') }}</span>
                          @endif
                      </div>
                      <div class="col-md-4 text-center">
                        <label class="font-weight-bold">Total Payment Amount:</label>
                        <input type="text" name="amount" id="totalAmount" class="form-control rounded-year" value="{{ old('amount', $product->amount) }}" readonly/>
                        @if($errors->has('currency'))
                            <span class="text-danger">{{ $errors->first('currency') }}</span>
                        @endif
                        @if($errors->has('amount'))
                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                        @endif
                    </div>
                  </div>  
                </div>

                  <div class="text-center row justify-content-center">
                    <div class="col-md-4">
                      <br>
                      <button type="submit" class="btn btn-outline-primary btn-outline-custom-primary font-weight-bold rounded-year w-100 shadow">Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Enter Subcategory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="categoryForm" method="POST" enctype="multipart/form-data" action="/mrc/sub_category">
                    @csrf
                    <div class="form-group modal-body row justify-content-center">
                        <div class="col-md-3">
                          <input type="hidden" value="product" name="category">
                          <label for="" class="font-weight-bold text-primary">Year:</label>
                          <input class="form-control rounded-year" type="text" name="year">
                          @if($errors->has('year'))
                              <span class="text-danger">{{ $errors->first('year') }}</span>
                          @endif
                        </div>
                        <div class="col-md-9">
                          <label for="" class="font-weight-bold text-primary">Subcategory:</label>
                          <input class="form-control rounded-year" type="text" name="sub_category">
                          @if($errors->has('sub_category'))
                              <span class="text-danger">{{ $errors->first('sub_category') }}</span>
                          @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-year" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded-year">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <script>
    // Get references to the input fields
    const rateInput = document.getElementById('rate');
    const tdsInput = document.getElementById('tds');
    const amcInput = document.getElementById('amc');
    const totalAmountInput = document.getElementById('totalAmount');

    // Add event listeners to the input fields
    rateInput.addEventListener('input', updateTotalAmount);
    tdsInput.addEventListener('input', updateTotalAmount);
    amcInput.addEventListener('input', updateTotalAmount);

    // Function to update the total payment amount
    function updateTotalAmount() {
        // Parse the values of rate, tds, and amc as floats
        const rate = parseFloat(rateInput.value) || 0;
        const tds = parseFloat(tdsInput.value) || 0;
        const amc = parseFloat(amcInput.value) || 0;

        // Calculate the total amount
        const totalAmount = rate + tds + amc;

        // Set the value of the total payment amount input field
        totalAmountInput.value = totalAmount.toFixed(2); // Optionally round to 2 decimal places
    }
  </script>
  <script>
    // Function to fetch the year from invoice_date when changed
    document.getElementById('invoice_date').addEventListener('change', function() {
        var invoiceDate = new Date(this.value);
        var year = invoiceDate.getFullYear();

        // Fetch the subcategories based on the selected year
        fetchSubcategories(year);
    });

    // Function to fetch subcategories based on the selected year
    function fetchSubcategories(year) {
        // AJAX request to fetch subcategories based on the year
        fetch(`/amc/subcategories/${year}`)
            .then(response => response.json())
            .then(data => {
                // Clear existing options
                document.getElementById('sub_category').innerHTML = '';

                // Append new options
                data.forEach(category => {
                    var option = document.createElement('option');
                    option.value = category.sub_category;
                    option.textContent = category.sub_category;
                    document.getElementById('sub_category').appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching subcategories:', error));
    }
</script>
  
@endsection
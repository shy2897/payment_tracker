@extends('layouts.test_test')

@section('test_test')

   <div class="d-flex align-items-center justify-content-center pb-0 mb-0">
    <div class=" btn record_btn py-0 col-md-3">
        <a href="/project_capex/create" class="btn btn-outline-primary btn-outline-custom-primary mt-1 ml-0 mr-5 rounded-button px-5"><h6 class=""> + Add New Record</h6></a>
    </div>

    <div class="search-bar col-md-3">
        <div class="box">
            <div class="search-box">
                <form action="search_data" method="GET">
                <input type="text" name="search" placeholder="Search" onclick="clearPlaceholder(this)">
                <button type="submit" class="icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                </form>
            </div>
        </div>
    </div>
   </div>

    <div class="table_display ">
        @foreach ($monthlyData as $record)
            @foreach($budgets as $budget)
            @php
                static $currentYear = null;
            @endphp
            @if ($currentYear !== $record->year && $record->year >= 2010 && $budget->year == $record->year) 
            <div class="table_display_year rounded-year mt-0">
                <table class="table my-0">
                    <thead class="text-primary">
                        <tr class="text-align-center px-2">
                            <th>
                                <h5 class="font-weight-bold text-month">{{ $record->year }}</h5>
                            </th>
                            <th>
                                <div class="d-flex justify-content-start align-items-center">
                                    <span class="pr-2">Budget: Nu. {{ $budget->budget }}</span>
                                    <!-- Button to edit the budget, triggers a modal -->
                                    <button type="button" class="btn btn-outline-primary btn-outline-custom-primary btn-sm edit-budget" data-toggle="modal" data-target="#budgetModal-{{ $record->year }}" data-budget-id="{{ $budget->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </div> 
                            </th>
                            <th class="text-right">Balance: Nu. {{ $budget->balance }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="budgetModal-{{ $record->year }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Edit Budget ({{ $budget->year }})</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="budgetForm-{{ $record->year }}" class="budget-form" method="POST" enctype="multipart/form-data" action="/project_capex/budget_edit/{{ $budget->id }}">
                            @csrf
                            <div class="form-group modal-body">
                                <input type="hidden" name="budgetId" id="budgetId-{{ $record->year }}" value="{{ $budget->id }}">
                                <input type="text" class="form-control rounded-year" name="edit" value="{{ $budget->budget }}" placeholder="Enter budget">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-year" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary rounded-year">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>               
        </div>
            @php
                $currentYear = $record->year;
            @endphp
            @endif
        @endforeach



            <div class="d-flex table_display justify-content-between">
                <div class="col-md-4 d-flex align-items-center">
                    <h6 class="text-month pr-3 font-weight-semibold">{{ $record->sub_category }}</h6> 
                    <a href="{{ route('generatePdf', ['year' => $record->year, 'month' => $record->sub_category]) }}" class="btn btn-sm btn-dark d-inline rounded">Generate PDF</a>
                </div>
                <div class="col-md-4 card rounded ml-5 p-0 mb-0">
                    @foreach($categories as $category)
                        @php
                            static $currentYear = null;
                        @endphp
                        @if ($currentYear !== $category->year && $record->year == $category->year  && $category->sub_category == $record->sub_category) 
                        <div class="card sub_category_budget p-1">
                            <div class="row align-items-center justify-content-between text-primary">
                                <div class="col-auto">
                                    <span class="pr-2">Budget: Nu. {{ $category->budget }}</span>
                                    <!-- Button to edit the budget, triggers a modal -->
                                    <button type="button" class="btn btn-outline-primary btn-outline-custom-primary btn-sm category-edit-budget" data-toggle="modal" data-target="#categoryBudgetModal-{{ $category->year }}" data-budget-id="{{ $category->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </div>
                            
                                <div class="col-auto text-right">
                                    Balance: Nu. {{ $category->balance }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="categoryBudgetModal-{{ $category->year }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary" id="exampleModalLabel">Edit Budget</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="categoryBudgetForm-{{ $record->year }}" class="budget-form" method="POST" enctype="multipart/form-data" action="/project_capex/category_budget_edit/{{ $category->id }}">
                                        @csrf
                                        <div class="form-group modal-body">
                                            <input type="hidden" name="budgetId" id="budgetId-{{ $category->year }}" value="{{ $category->id }}">
                                            <input type="text" class="form-control rounded-year" name="edit" value="" placeholder="Enter budget">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary rounded-year" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary rounded-year">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @php
                            $currentYear = $record->year;
                        @endphp
                        @endif
                    
                    @endforeach
                </div>
            </div>
        
            <table class="table table_display table-hover rounded mt-3">
                <thead class="bg-primary shadow header-text">
                    <tr>
                        <th class="fixed-status">Status</th> 
                        <th class="fixed-invoice">Invoice No.</th>
                        <th class="fixed-date">Invoice Date</th>
                        <th class="fixed-vendor">Vendor</th>
                        <th class="fixed-description">Description</th>
                        <th class="fixed-amount">Amount</th>
                        <th class="fixed-action">Action</th>
                        <th class="fixed-pay">Payment</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $products = $products->sortBy('invoice_date');

                    @endphp

                    @foreach($products as $product)
                    @if (date("Y", strtotime($product->invoice_date)) == $record->year && $product->sub_category == $record->sub_category)
                            <tr class="">
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
                                        <a href="/mrc/{{ $product->id }}/show" class="">
                                            {{ $product->invoice_no }}</a>
                                </td>

                                <td>{{ date('d/m/Y', strtotime($product->invoice_date)) }}</td>


                                <td>{{ $product->vendor }} 
                                </td>

                                <td>{{ $product->description }} 
                                </td>

                                <td>
                                    @if($product->currency === 'USD')
                                        <button type="button" class="btn btn-outline-dark btn-sm rounded-year" data-toggle="modal" data-target="#rateModal" data-product-id="{{ $product->id }}">
                                            <i class="fa-solid fa-money-bill-transfer"></i>
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Enter USD rate for conversion to BTN</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="rateForm" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group modal-body">
                                                            <input type="hidden" name="product_id" id="product_id" value="">
                                                            <input class="form-control rounded-year" type="text" name="usd_rate">
                                                            @if($errors->has('usd_rate'))
                                                                <span class="text-danger">{{ $errors->first('usd_rate') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary rounded-year" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary rounded-year">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <b>{{ $product->currency }}</b>
                                    {{ $product->amount }}
                                        
                                </td>
                                
                                <td>
                                
                                    <a href="{{ $product->id }}/show"
                                    class="btn btn-outline-success btn-outline-custom-success btn-sm rounded-button"><i class="fa-solid fa-eye"></i></a>

                                    @if($product->status == 'approved')
                                        <a href="#" class="btn btn-outline-info btn-outline-custom-info btn-sm rounded-button" disabled>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    @else
                                        <a href="{{ $product->id }}/edit" class="btn btn-outline-info btn-sm rounded-button">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    @endif

                                    <button type="button" class="btn btn-outline-danger btn-outline-custom-danger btn-sm rounded-button" data-toggle="modal" data-target="#confirmDeleteModal" data-productid="{{ $product->id }}"><i class="fa-solid fa-trash"></i></button>

                                    <!-- Confirmation Modal -->
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-primary font-weight-bold" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <b>Invoice No:</b> {{ $product->invoice_no }} <br>
                                                    <b>Description: </b> {{ $product->description }} <br> <br>
                                                    <b>Are you sure you want to delete this record? </b>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-year" data-dismiss="modal">No</button>
                                                    <form class="d-inline" id="deleteForm" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-year">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td class="text-center">
                                     <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#approveModal" data-product-id="{{ $product->id }}">
                                        <i class="fa-solid fa-check"></i>
                                      </button>

                                      <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-primary font-weight-bold" id="approveModalLabel">Approve Record</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="approveForm" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group modal-body">
                                                        <input type="hidden" name="product_id" id="product_id" value="">
                                                        <b>Invoice No:</b> {{ $product->invoice_no }} <br>
                                                        <b>Description: </b> {{ $product->description }} <br> <br>
                                                        <b>Are you sure you want to approve this record? </b>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary rounded-year" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success rounded-year">Approve</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                      <button type="button" class="btn btn-outline-danger btn-outline-custom-danger btn-sm" data-toggle="modal" data-target="#exampleModal" data-product-id="{{ $product->id }}">
                                        <i class="fa-solid fa-xmark"></i>
                                      </button>
                                      
                                      <!-- Reject Modal -->
                                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Reject Record</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <form id="rejectForm" method="POST" enctype="multipart/form-data">
                                                      @csrf
                                                      <div class="form-group modal-body">
                                                          <input type="hidden" name="product_id" id="product_id" value="">
                                                          <b>Invoice No:</b> {{ $product->invoice_no }} <br>
                                                          <b>Description: </b> {{ $product->description }} <br> <br>
                                                          <b>Reason for rejection: </b> <br>
                                                          <textarea class="form-control rounded-year" name="remarks" rows="2"></textarea>
                                                          @if($errors->has('remarks'))
                                                              <span class="text-danger">{{ $errors->first('remarks') }}</span>
                                                          @endif
                                                      </div>
                                                      <div class="modal-footer">
                                                          <button type="button" class="btn btn-secondary rounded-year" data-dismiss="modal">Close</button>
                                                          <button type="submit" class="btn btn-danger rounded-year">Reject</button>
                                                      </div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br>

        @endforeach
    </div>


    <script>

        $(document).ready(function() {
            $('.edit-budget').click(function() {
                var budgetId = $(this).data('budget-id');
                var modalId = $(this).data('target');
                var year = modalId.split('-')[1];
                $('#budgetId-' + year).val(budgetId);
                $('#budgetForm-' + year).attr('action', '/project_capex/budget_edit/' + budgetId);
            });
        });

        $(document).ready(function() {
            $('.category-edit-budget').click(function() {
                var budgetId = $(this).data('budget-id');
                var modalId = $(this).data('target');
                var year = modalId.split('-')[1];
                $('#budgetId-' + year).val(budgetId);
                $('#categoryBudgetForm-' + year).attr('action', '/project_capex/category_budget_edit/' + budgetId);
            });
        });
    
        $('#rateModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('product-id');
            $('#product_id').val(productId);
            var formAction = "/project_capex/" + productId + "/usd_rate";
            $('#rateForm').attr('action', formAction);
        });

        //Approve Modal
        $('#approveModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('product-id');
            $('#product_id').val(productId);
            var formAction = "/project_capex/" + productId + "/approve";
            $('#approveForm').attr('action', formAction);
        });

        //Reject Modal
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('product-id');
            $('#product_id').val(productId);
            var formAction = "/project_capex/" + productId + "/reject";
            $('#rejectForm').attr('action', formAction);
        });

         //DELETE CONFIRMATION MODAL
         $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var productId = button.data('productid'); // Extract product ID from data-attribute
            var form = $(this).find('form'); // Find the form within the modal
            form.attr('action',  productId + '/delete'); // Set the action attribute of the form
        });

    </script>

       
@endsection

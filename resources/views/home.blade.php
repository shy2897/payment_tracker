@extends('layouts.test_test')

@section('test_test')

<style>
    .circle {
        width: 140px; /* Adjust size as needed */
        height: 140px; /* Adjust size as needed */
        border-radius: 50%; /* Ensures it's a circle */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .circle-record {
        border: 6px solid #1c4e80;
    }

    .circle-pending {
        border: 6px solid #ffc107;
    }

    .circle-approved {
        border: 6px solid #28a745;
    }

    .circle-rejected {
        border: 6px solid #dc3545;
    }
    .text {
        text-align: center;
    }

    .circle-badge {
    display: inline-block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    text-align: center;
    line-height: 40px;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 5px;
    margin-right: 3px;
    margin-left: 3px;

  }

  .card-text {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #252D60; /* Set default text color to black */
  }

  .circle-description {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #1c4e80; /* Set default text color to black */
  }

  .bg-dark {
    background-color: #f5f2f2!important; /* Lighter background color */
  }

  .bg-yellow {
    border: 2px solid #ffc107 !important;
  }

  .bg-green {
    border: 2px solid #28a745 !important;
  }

  .bg-red {
    border: 2px solid #dc3545 !important;
  }

  /* Set text color for circle description based on background color */
  .bg-yellow .circle-description {
    color: #ffc107;
  }

  .bg-green .circle-description {
    color: #28a745;
  }

  .bg-red .circle-description {
    color: #dc3545;
  }

  .btn:hover {
    text-decoration: none; /* Remove default underline */
    box-shadow: 0 0 10px #ffc107; /* Add box shadow with the same color */
  }

</style>

    <div class="row m-1 justify-content-center">
        <div class="card shadow col-md-2 p-1 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="circle circle-record">
                <div class="text">
                    <h3>{{ $total_records }}</h3> <!-- Add your text here -->
                </div>        
            </div>
            <div>
                <h4>Records</h4>
            </div>
        </div>
        <div class="card shadow col-md-2 p-1 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="circle circle-pending">
                <div class="text">
                    <h3>{{ $total_pending }}</h3> <!-- Add your text here -->
                </div>        
            </div>
            <div>
                <h4>Pending</h4>
            </div>
        </div>
        <div class="card shadow col-md-2 p-1 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="circle circle-approved">
                <div class="text">
                    <h3>{{ $total_approved }}</h3> <!-- Add your text here -->
                </div>        
            </div>
            <div>
                <h4>Approved</h4>
            </div>
        </div>
        <div class="card shadow col-md-2 p-1 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="circle circle-rejected">
                <div class="text">
                    <h3>{{ $total_rejected }}</h3> <!-- Add your text here -->
                </div>        
            </div>
            <div>
                <h4>Rejected</h4>
            </div>
        </div>
    </div>


    <div class="row m-1 justify-content-center">
        <div class="card shadow col-md-2 py-3 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="text">
                <p class="card-text">AMC</p>
                <div class="row">
                    <div class="circle-badge bg-yellow">{{ $change_pending }}</div>
                    <div class="circle-badge bg-green">{{ $change_approved }}</div>
                    <div class="circle-badge bg-red">{{ $change_rejected }}</div>
                </div>
            </div>    
        </div>
        <div class="card shadow col-md-2 py-3 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="text">
                <p class="card-text">MRC</p>
                <div class="row justify-content-center">
                    <div class="circle-badge bg-yellow">{{ $product_pending }}</div>
                    <div class="circle-badge bg-green">{{ $product_approved }}</div>
                    <div class="circle-badge bg-red">{{ $product_rejected }}</div>
                </div>
            </div>
        </div>
        <div class="card shadow col-md-2 py-3 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="text">
                <p class="card-text">Annual Capex</p>
                <div class="row justify-content-center">
                    <div class="circle-badge bg-yellow">{{ $annual_pending }}</div>
                    <div class="circle-badge bg-green">{{ $annual_approved }}</div>
                    <div class="circle-badge bg-red">{{ $annual_rejected }}</div>
                </div>
            </div>
        </div>
        <div class="card shadow col-md-2 py-3 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="text">
                <p class="card-text">Project Capex</p>
                <div class="row justify-content-center">
                    <div class="circle-badge bg-yellow">{{ $capex_pending }}</div>
                    <div class="circle-badge bg-green">{{ $capex_approved }}</div>
                    <div class="circle-badge bg-red">{{ $capex_rejected }}</div>
                </div>
            </div>
        </div>
        <div class="card shadow col-md-2 py-3 m-1 rounded-year pr-6 justify-content-center align-items-center">
            <div class="text">
                <p class="card-text">Project Opex</p>
                <div class="row justify-content-center">
                    <div class="circle-badge bg-yellow">{{ $opex_pending }}</div>
                    <div class="circle-badge bg-green">{{ $opex_approved }}</div>
                    <div class="circle-badge bg-red">{{ $opex_rejected }}</div>
                </div>
            </div>
        </div>
    </div>
       
@endsection

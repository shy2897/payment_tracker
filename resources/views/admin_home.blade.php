@extends('layouts.app_admin')

@section('main_admin')

<style>
  .card-group {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 20px;
  }

  .card {
    width: 30px !important;  /* Reduced width */
    border-radius: 10px !important;
    margin: 30px;
    color: #000; /* Changed text color to black */
    box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1); /* Added box shadow for a lighter look */
  }

  .card-body {
    padding: 10px;
  }

  .circle-badge {
    display: inline-block;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    text-align: center;
    line-height: 30px;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .card-text {
    display: block;
    font-size: 18px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #feb139; /* Set default text color to black */
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
    background-color: #ffc107 !important;
  }

  .bg-green {
    background-color: #28a745 !important;
  }

  .bg-red {
    background-color: #dc3545 !important;
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

<div class="card-group">
  <!-- New project details card -->
  
  <div class="card bg-dark ml-4">
    <a href="/admin/product" class="btn" >
    <div class="card-body text-center">
      <p class="card-text">New project Details</p>
      <div class="circle-badge bg-yellow">{{ $product_pending }}</div>
      <div class="circle-description">Pending</div>
      <div class="circle-badge bg-green">{{ $product_approved }}</div>
      <div class="circle-description">Approved</div>
      <div class="circle-badge bg-red">{{ $product_rejected }}</div>
      <div class="circle-description">Rejected</div>
    </div>
    </a>
  </div>

  <!-- Annual details card -->
  <div class="card bg-dark">
    <a href="/admin/annual/dashboard" class="btn">
    <div class="card-body text-center">
      <p class="card-text">Annual Details</p>
      <div class="circle-badge bg-yellow">{{ $annual_pending }}</div>
      <div class="circle-description">Pending</div>
      <div class="circle-badge bg-green">{{ $annual_approved }}</div>
      <div class="circle-description">Approved</div>
      <div class="circle-badge bg-red">{{ $annual_rejected }}</div>
      <div class="circle-description">Rejected</div>
    </div>
  </a>
  </div>

  <!-- Change details card -->
  <div class="card bg-dark">
    <a href="/admin/change/dashboard" class="btn">
    <div class="card-body text-center">
      <p class="card-text">Change Details</p>
      <div class="circle-badge bg-yellow">{{ $change_pending }}</div>
      <div class="circle-description">Pending</div>
      <div class="circle-badge bg-green">{{ $change_approved }}</div>
      <div class="circle-description">Approved</div>
      <div class="circle-badge bg-red">{{ $change_rejected }}</div>
      <div class="circle-description">Rejected</div>
    </div>
  </a>
  </div>
  
</div>

    
@endsection
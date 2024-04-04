<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project Payment Tracker</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>

      body {
          font-family: 'Poppins', sans-serif;
      }

      .fixed-invoice{
        width: 200px;
      }
      .fixed-date{
        width: 150px;
      }
      .fixed-description{
        width: 600px;
      }
      .fixed-amount{
        width: 225px;
      }
      .fixed-action{
        width: 300px;
      }

      .navbar {
        border-radius: 8px;
        background-color: #1c4e80 !important; /* Use your primary color here */
        margin-bottom: 0;
        padding-bottom: 0;
        height: 65px;
      }
      .navbar-nav .nav-item {
        border-radius: 10px;
        margin-bottom: 0;
        padding-bottom: 0;
      }

      .navbar-nav .nav-item.active {
        background-color: white !important;
        border-radius: 10px 10px 0 0 !important; /* Adjust the value to match the navbar radius */
        border-bottom: 16px solid white; /* Add a bottom border to join with the rest of the page */
      }

      .navbar-nav .nav-item.active a {
        color: #feb139 !important; /* Use your primary color here */
      }

      .btn-primary {
        background-color: #1c4e80 !important; /* Use your primary color here */
      }

      .bg-primary {
        background-color: #1c4e80 !important; /* Use your primary color here */
      }

      .text-month {
        color: #feb139; /* Use your primary color here */
      }

      .text-primary {
        color: #1c4e80 !important; /* Use your primary color here */
      }

      .header-text {
        color:#fff;
      }

      .rounded {
        border-radius: 20px;
        overflow: hidden;
      }

      .dash-icon {
        width: 50px;
        height: 50px;
      }

      .profile-icon {
        width: 20px;
        height: 20px;
      }
      
    </style>

</head>
<body>
  
  <nav class="navbar navbar-expand-sm bg-primary" style="position: sticky; top: 0; z-index: 100;">
    <!-- Links -->
    <ul class="navbar-nav mr-auto">
  
      <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
        <a class="nav-link text-light font-weight-bold mx-3" href="/dashboard">Home</a>
      </li>
      <li class="nav-item {{ Request::is('product*') ? 'active' : '' }}">
        <a class="nav-link text-light font-weight-bold mx-3" href="/product">New Project</a>
      </li>
      <li class="nav-item {{ Request::is('annual*') ? 'active' : '' }}">
        <a class="nav-link text-light font-weight-bold mx-3" href="/annual">Annual</a>
      </li>
      <li class="nav-item {{ Request::is('change*') ? 'active' : '' }}">
        <a class="nav-link text-light font-weight-bold mx-3" href="/change">Change Request</a>
      </li>
    </ul>
  
    <div class="dropdown">
      <button type="button" class="btn btn-primary dropdown-toggle font-weight-bold" data-toggle="dropdown">
        <img src="{{ asset('storage/profile.png') }}" alt="" class="profile-icon">  {{ Auth::user()->name }}
      </button>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item text-primary font-weight-bold" href="{{ route('profile.edit') }}">
          Profile Edit
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a class="dropdown-item text-primary font-weight-bold" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
            Logout
          </a>
        </form>
      </div>
    </div>
  </nav>
  
    
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <strong>{{ $message }}</strong>
      </div>
    @endif

    @yield('main_test')

</body>
</html>
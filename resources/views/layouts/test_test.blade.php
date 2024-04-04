<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project Payment Tracker</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/test.css') }}">
    

</head>
<body>

  <header>
    <div class="navbar_custom">
      <div class="logo nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
        <a href="/dashboard">Payment Tracker <i class="fa-solid fa-file-invoice-dollar"></i> <i class="fa-solid fa-arrow-trend-up"></i></a>
      </div>
      <ul class="links mt-2">
        <li class="nav-item {{ Request::is('amc*') ? 'active' : '' }}"><a href="/amc">AMC</a></li>
        <li class="nav-item {{ Request::is('mrc*') ? 'active' : '' }}"><a href="/mrc">MRC</a></li>
        <li class="nav-item {{ Request::is('annual_capex*') ? 'active' : '' }}"><a href="/annual_capex">Annual CAPEX</a></li>
        <li class="nav-item {{ Request::is('project_capex*') ? 'active' : '' }}"><a href="/project_capex">Project CAPEX</a></li>
        <li class="nav-item {{ Request::is('project_opex*') ? 'active' : '' }}"><a href="/project_opex">Project OPEX</a></li>
      </ul>
      <span>
        <a href="{{ route('profile.edit') }}" class="action_btn"> <i class="fa-solid fa-user"></i> Profile</a>
        <form method="POST" action="{{ route('logout') }}" class="mt-2 action-btn">
          @csrf
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="action_btn"> <i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </form>
      </span>
      <div class="toggle_btn">
        <i class="fa-solid fa-bars"></i>
      </div>
    </div>

    <div class="dropdown_menu">
        <li class="{{ Request::is('amc*') ? 'active' : '' }}"><a href="/amc">AMC</a></li>
        <li class="{{ Request::is('mrc*') ? 'active' : '' }}"><a href="/mrc">MRC</a></li>
        <li class="{{ Request::is('annual_capex*') ? 'active' : '' }}"><a href="/annual_capex">Annual CAPEX</a></li>
        <li class="{{ Request::is('project_capex*') ? 'active' : '' }}"><a href="/project_capex">Project CAPEX</a></li>
        <li class="{{ Request::is('project_opex*') ? 'active' : '' }}"><a href="/project_opex">Project OPEX</a></li>
        <div class="action">
          <li><a href="{{ route('profile.edit') }}" class="action_btn"> <i class="fa-solid fa-user"></i>  Profile</a></li>
          <li>
            <form method="POST" class="action-btn" action="{{ route('logout') }}">
              @csrf
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="action_btn"> <i class="fa-solid fa-right-from-bracket"></i>  Logout</a></li>
            </form>
        </div>
    </div>

  </header>
    
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <strong>{{ $message }}</strong>
      </div>
    @endif

    @yield('test_test')


    <script src="{{ asset('js/test.js') }}"></script>
    

</body>
</html>
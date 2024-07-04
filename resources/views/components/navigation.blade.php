<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Nav Bar</title>
  <link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.2.0/css/all.css'>
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <style>
:root {
  --background: #4285f4;
  --icon-color: #ffffff;
  --width: 50px;
  --height: 50px;
  --border-radius: 100%;
}

body {
  background: #fff;
  background-color: #eff8e2;
  height: 100vh;
  font-family: "Lexend Deca", sans-serif;
  display: flex;
  align-items: center;
  overflow: hidden;
  margin: 0;
  padding: 0;

  background: rgb(255,255,255);
    background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(140,140,140,1) 100%);
}

.wrapper {
  width: var(--width);
  height: var(--height);
  position: absolute;
  left: 3rem;
  top: 50%;
  transform: translateY(-50%);
  border-radius: var(--border-radius);
  display: flex;
  justify-content: center;
  align-items: center;
}

.fac {
  width: 60px;
  height: 700px;
  border-radius: 64px;
  position: absolute;
  background: #001f5e;
  z-index: 2;
  padding: 0.5rem 0.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
  top: -325px;
  opacity: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  align-items: center;
}

.fac a {
  color: var(--icon-color);
  opacity: 0.8;
  position: relative;
  display: inline-block;
  margin-bottom: 10px; /* Adjust the space between links */
}

.fac a .tooltip,
.logout-button .tooltip { /* Apply tooltip styles to both .fac a and .logout-button */
  visibility: hidden;
  width: auto; /* Adjust width to fit content */
  background-color: #30444f;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 10px;
  position: absolute;
  z-index: 1;
  left: 150%; /* Position to the right of the icon */
  top: 50%;
  margin-left: 10px; /* Add space between the icon and the tooltip */
  transform: translateY(-50%); /* Center the tooltip vertically */
  white-space: nowrap; /* Prevents the tooltip from wrapping */
  opacity: 0;
  transition: opacity 0.2s;
}

.fac a:hover .tooltip,
.logout-button:hover .tooltip { /* Show tooltip on hover for both .fac a and .logout-button */
  visibility: visible;
  opacity: 1;
}

.logout-button {
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0;
  color: var(--icon-color);
  position: relative;
}

.logout-button .text {
  margin-top: 0.5rem;
}

  </style>
</head>
<body>
<div class="wrapper">
  <div class="fac">
  <a href="{{ route('home') }}" class="tooltip-container">
  <i class='bx bxs-home bx-sm'></i>
  <span class="tooltip">Home</span>
</a>

  <a href="{{ route('dashboard') }}" class="tooltip-container">
  <i class='bx bxs-dashboard bx-spin bx-flip-horizontal icon bx-sm'></i>
  <span class="tooltip">Dashboard</span>
</a>

<a href="{{ route('dsr') }}" class="tooltip-container">
  <i class='bx bx-calculator icon bx-sm'></i>
  <span class="tooltip">Debt Service Ratio</span>
</a>

<a href="{{ route('assets') }}" class="tooltip-container">
  <i class='bx bx-building-house bx-sm'></i>
  <span class="tooltip">My Assets</span>
</a>

<a href="{{ route('property') }}" class="tooltip-container">
  <i class='bx bx-home-circle bx-sm'></i>
  <span class="tooltip">Property Loan Calculator</span>
</a>

<a href="{{ route('investment') }}" class="tooltip-container">
  <i class='bx bx-money-withdraw bx-sm'></i>
  <span class="tooltip">Investment Loan Calculator</span>
</a>

<a href="{{ route('liabilities') }}" class="tooltip-container">
  <i class='bx bx-book-content bx-sm'></i>
  <span class="tooltip">Liabilities</span>
</a>

<a href="{{ route('car') }}" class="tooltip-container">
  <i class='bx bx-car bx-sm'></i>
  <span class="tooltip">Car Loan Calculator</span>
</a>

<a href="{{ route('credit') }}" class="tooltip-container">
  <i class='bx bx-credit-card bx-sm'></i>
  <span class="tooltip">Credit Loan Calculator</span>
</a>

<a href="{{ route('personal') }}" class="tooltip-container">
  <i class='bx bx-money bx-sm'></i>
  <span class="tooltip">Personal Loan Calculator</span>
</a>

<a href="{{ route('policy') }}" class="tooltip-container">
  <i class='bx bx-file icon bx-sm'></i>
  <span class="tooltip">Policy</span>
</a>
@php
      $logoutText = auth()->check() ? 'Logout' : 'Register';
    @endphp

    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="logout-button" onclick="confirmLogout(event)">
        <i class='bx bx-log-out icon bx-sm'></i><br>
        <span class="tooltip">{{ $logoutText }}</span>
      </button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmLogout(event) {
    event.preventDefault(); // Prevent default form submission

    @if(auth()->check())
      Swal.fire({
        title: 'Logout',
        text: 'Are you sure you want to logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, logout',
        heightAuto: false,
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // If user confirms, submit the form
          document.getElementById('logout-form').submit();
        }
      });
    @else
      window.location.href = "{{ route('register') }}";
    @endif
  }
</script>
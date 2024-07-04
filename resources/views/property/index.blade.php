<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Property Loan Calculator</title>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calculators.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel="stylesheet">
    <!-- Styles -->
    <style>
    </style>
</head>
<body class="background-image" style="background-image: url('images/cold.jpg');">
<x-navigation :pageTitle="$pageTitle" />

<div class="loan-container">
    <b><h2>Property Loan Calculator</h2></b><br>
   
    <form id="loan-form" action="{{ route('save-property') }}" method="POST">
        @csrf
        <div class="form-group">
            <b><label for="property_price">Property Price: RM &nbsp; </label></b>
            <input type="text" id="property_price" name="property_price" required>
        </div>
        <div class="form-group">
            <b><label for="interest_rate">Interest Rate: &nbsp; </label></b>
            <input type="text" id="interest_rate" name="interest_rate" required> &nbsp;
            <b>%</b>
        </div>
        <div class="form-group">
            <b><label for="loan_tenure">Loan Tenure: </label></b>
            <input type="text" id="loan_tenure" name="loan_tenure" required> &nbsp;
            <b>Years</b>
        </div>
        <b><div id="result"></div><b><br>
        <button class="btn" type="button" onclick="calculateMonthlyPayment()">Calculate</button>  
        <button class="btn" type="submit">Save</button>  
        @if (!auth()->check())
    <script>
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission

            Swal.fire({
                title: 'Error',
                text: 'You must be logged in to use this feature!',
                icon: 'error',
                showCancelButton: false,
                confirmButtonText: 'OK',
                position: 'center', // Set position to center
                heightAuto: false
            });
        });
    </script>
@endif
    </form>
</div>

<script>
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function calculateMonthlyPayment() {
        var propertyPrice = parseFloat(document.getElementById('property_price').value);
        var interestRate = parseFloat(document.getElementById('interest_rate').value) / 100;
        var loanTenureYears = parseInt(document.getElementById('loan_tenure').value);
        var loanTenureMonths = loanTenureYears * 12;

        // Monthly interest rate
        var monthlyInterestRate = interestRate / 12;

        // Calculate monthly payment using the formula
        var monthlyPayment = (propertyPrice * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, loanTenureMonths)) /
            (Math.pow(1 + monthlyInterestRate, loanTenureMonths) - 1);

        // Calculate total interest
        var totalInterest = (monthlyPayment * loanTenureMonths) - propertyPrice;

        // Display the result
        document.getElementById('result').innerHTML = "<p><b>Monthly Payment:</b> RM " + formatNumber(monthlyPayment.toFixed(2)) + "</p>" +
            "<p><b>Total Interest:</b> RM " + formatNumber(totalInterest.toFixed(2)) + "</p>";
    }
</script>

</body>
</html>

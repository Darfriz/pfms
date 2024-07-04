<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
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

  </header> <br>

  <div class="loan-container">
        <b><h2>Credit Card Loan Calculator</h2></b><br>
        <form id="loan-form">
            <div class="form-group">
                <b><label for="username">Current Credit Card Balance: RM &nbsp; </label></b>
                <input type="number" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <b><label for="password">Interest Rate: &nbsp; </label></b>
                <input type="number" id="interest_rate" name="interest_rate" required> &nbsp;
                <b>%</b>
            </div>
            <div id="result"></div><br>
            <button class="btn" type="submit">Calculate</button>
            <button class="btn" type="submit">Save</button>  
        </form>
    </div>
    </body>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Find the form and attach submit event listener
    var form = document.getElementById('loan-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        
        // Retrieve input values
        var currentBalance = parseFloat(document.getElementById('username').value);
        var annualInterestRate = parseFloat(document.getElementById('interest_rate').value);
        
        // Validate input values
        if (isNaN(currentBalance) || isNaN(annualInterestRate)) {
            alert("Please enter valid numeric values.");
            return;
        }
        
        // Calculate minimum monthly payment (whichever is higher: RM50 or 5% of current balance)
        var minimumPayment = Math.max(50, currentBalance * 0.05);
        
        // Convert annual interest rate to monthly rate
        var monthlyInterestRate = annualInterestRate / 12 / 100; // Convert percentage to decimal
        
        // Calculate total interest
        var totalInterest = (currentBalance * monthlyInterestRate); // Assuming monthly interest
        
        // Display results
        //alert("Minimum Monthly Payment: RM" + minimumPayment.toFixed(2) + "\nTotal Interest: RM" + totalInterest.toFixed(2));

        // Update the result display
    document.getElementById('result').innerHTML = "<p><b>Minimum Monthly Payment: RM" + minimumPayment.toFixed(2) + "</p>" +
        "<p><b>Total Interest:</b> RM " + totalInterest.toFixed(2) + "</p>";
    });
});

    </script>
</html>

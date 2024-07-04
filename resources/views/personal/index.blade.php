<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Loan Calculator</title>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calculators.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel="stylesheet">
    <!-- Styles -->
    <style>
        .progress-bar-container {
            width: 80%;
            margin: 20px auto;
            background-color: #f0f0f0;
            border-radius: 10px;
            height: 25px; /* Increased height to accommodate the percentage */
            position: relative;
        }

        .progress-bar {
            height: 100%;
            border-radius: 10px;
            background-color: #007bff;
            transition: width 0.8s ease-in-out;
            position: relative;
        }

        .progress-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
        }

        #result {
            margin-top: 20px;
        }
    </style>
</head>
<body class="background-image" style="background-image: url('images/cold.jpg');">
<x-navigation :pageTitle="$pageTitle" />

<div class="loan-container">
    <b><h2>Personal Loan Calculator</h2></b><br>
    <form id="loan-form" action="{{ route('save-PersonalLiabilities') }}" method="POST">
    @csrf
    <form id="loan-form">
        <div class="form-group">
            <b><label for="loan_amount">Loan Amount: RM &nbsp; </label></b>
            <input type="text" id="loan_amount" name="loan_amount" required>
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
        <div id="result"></div><br>
        <div class="progress-bar-container">
            <div class="progress-bar" id="progress-bar" style="width: 0;"></div>
            <div class="progress-percentage" id="progress-percentage">0%</div>
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function calculateMonthlyPayment() {
    var loanAmount = parseFloat(document.getElementById('loan_amount').value);
    var interestRate = parseFloat(document.getElementById('interest_rate').value) / 100;
    var loanTenureYears = parseInt(document.getElementById('loan_tenure').value);
    var loanTenureMonths = loanTenureYears * 12;

    // Monthly interest rate
    var monthlyInterestRate = interestRate / 12;

    // Calculate monthly payment using the formula
    var monthlyPayment = (loanAmount * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, loanTenureMonths)) /
        (Math.pow(1 + monthlyInterestRate, loanTenureMonths) - 1);

    // Calculate total interest
    var totalInterest = (monthlyPayment * loanTenureMonths) - loanAmount;

    // Calculate total payment (loan amount + total interest)
    var totalPayment = loanAmount + totalInterest;

    // Update the result display
    document.getElementById('result').innerHTML = "<p><b>Monthly Payment:</b> RM " + monthlyPayment.toFixed(2) + "</p>" +
        "<p><b>Total Interest:</b> RM " + totalInterest.toFixed(2) + "</p>";

    // Update the progress bar
    var progressBar = document.getElementById('progress-bar');
    var progressBarWidth = (loanAmount / totalPayment) * 100; // Calculate percentage based on total payment
    progressBar.style.width = progressBarWidth + '%';

    // Update the progress percentage display
    var progressPercentage = document.getElementById('progress-percentage');
    progressPercentage.innerHTML = progressBarWidth.toFixed(2) + '% Loan Amount';
}
</script>

</body>
</html>

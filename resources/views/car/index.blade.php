<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Car Loan</title>
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/calculators.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel="stylesheet">

        <!-- Styles -->
        <style>
.down_payment-btn {
    background-color: #ccc; /* Grey color */
    color: #000000;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
}

.down_payment-btn.selected {
    color: #fff;
    background-color: #4CAF50; /* Green color */
}

.loan_tenure-btn {
    width: 70px;
    height: 30px;
    border: none;
    border-radius: 10%;
    background-color: #ccc;
    color: #000000;
    font-size: 14px;
    cursor: pointer;
}

.loan_tenure-btn.selected {
    color: #fff;
    background-color: #4CAF50; /* Green color */
}





        </style>
</head>

    <body class="background-image" style="background-image: url('images/cold.jpg');">
    <x-navigation :pageTitle="$pageTitle" />
    
    <div class="loan-container">
        <b><h2>Car Loan Calculator</h2></b><br>
        <form id="loan-form" action="{{ route('save-CarLiabilities') }}" method="POST">
    @csrf
            <div class="form-group">
                <b><label for="car_price">Car Price: RM &nbsp; </label></b>
                <input type="number" id="car_price" name="car_price" required>
            </div>
            <div class="form-group">
                <b><label for="down_payment">Down Payment: &nbsp; </label></b>
                <div id="down_payment-buttons">
                    <button type="button" class="down_payment-btn" value="0.1">10% For New/Recond Car</button>
                    <button type="button" class="down_payment-btn" value="0.2">20% For Used Car</button>
                </div>
                
            </div>
            <input type="block" id="down_payment" name="down_payment" value=""><br>
            <div class="form-group">
                <b><label for="loan_tenure">Loan Tenure In Years: &nbsp; </label></b> 
                <div id="loan_tenure-buttons">
                    <button type="button" class="loan_tenure-btn" value="1">3 </button>
                    <button type="button" class="loan_tenure-btn" value="5">5 </button>
                    <button type="button" class="loan_tenure-btn" value="7">7 </button>
                    <button type="button" class="loan_tenure-btn" value="9">9 </button>
                </div>
                <input type="hidden" id="loan_tenure" name="loan_tenure" value="">
            </div>
            <div class="form-group">
                <b><label for="interest_rate">Interest Rate: &nbsp; </label></b>
                <input type="number" id="interest_rate" name="interest_rate" required> &nbsp; 
                <b>%</b>
            </div>
            <div class="form-group">
                <b><label for="annual_insurance">Annual Insurance Price: RM &nbsp; </label></b>
                <input type="number" id="annual_insurance" name="annual_insurance" required>
            </div>
            <div class="form-group">
                <b><label for="annual_road_tax">Annual Road Tax Price: RM &nbsp; </label></b>
                <input type="number" id="annual_road_tax" name="annual_road_tax" required>
            </div>
            <div class="form-group">
                <b><label for="fuel_consumption">Fuel Consumption: &nbsp; </label></b>
                <input type="number" id="fuel_consumption" name="fuel_consumption" required> &nbsp; 
                <b>KM/L</b>
            </div>
            <div class="form-group">
                <b><label for="estimated_distance">Estimated Distance Travelled: &nbsp;  </label></b>
                <input type="number" id="estimated_distance" name="estimated_distance" required> &nbsp; 
                <b>KM</b>
            </div>

            <b><div id="monthlyPaymentResult"></div><b><br>
            <b><div id="monthlyInsuranceResult"></div><b><br>
            <b><div id="monthlyRoadtaxResult"></div><b><br>
            <b><div id="fuelCostResult"></div><b><br>
            <b><div id="totalCarMonthlyPaymentResult"></div><b><br>
            <button class="btn" type="button" id="calculate-button">Calculate</button>
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
    </body>
    <script>
// Helper function to format numbers with commas as thousand separators
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Calculate the car loan
function calculateLoan() {
    // Retrieve input values
    var carPrice = parseFloat(document.getElementById('car_price').value);
    var downPayment = parseFloat(document.getElementById('down_payment').value);
    var loanTenure = parseFloat(document.getElementById('loan_tenure').value);
    var interestRate = parseFloat(document.getElementById('interest_rate').value);
    var annualInsurance = parseFloat(document.getElementById('annual_insurance').value);
    var annualRoadTax = parseFloat(document.getElementById('annual_road_tax').value);
    var fuelConsumption = parseFloat(document.getElementById('fuel_consumption').value);
    var estimatedDistance = parseFloat(document.getElementById('estimated_distance').value);

    // Check if input values are valid numbers
    if (isNaN(carPrice) || isNaN(interestRate) ||
        isNaN(annualInsurance) || isNaN(annualRoadTax) || isNaN(fuelConsumption) || isNaN(estimatedDistance)) {
        alert("Please enter valid numeric values.");
        return;
    }

    // Calculate monthly payment
    var monthlyPayment = calculateMonthlyPayment(carPrice, downPayment, loanTenure, interestRate);
    var monthlyInsurance = calculateMonthlyInsurance(annualInsurance);
    var monthlyRoadtax = calculateMonthlyRoadtax(annualRoadTax);
    var fuelCost = calculateFuelCost(estimatedDistance, fuelConsumption);
    var totalCarMonthlyPayment = monthlyPayment + monthlyInsurance + monthlyRoadtax + fuelCost;

    // Display the calculated loan details with formatted numbers
    document.getElementById("monthlyPaymentResult").innerHTML = "Monthly Payment: RM" + formatNumber(monthlyPayment.toFixed(2));
    document.getElementById("monthlyInsuranceResult").innerHTML = "Monthly Insurance: RM" + formatNumber(monthlyInsurance.toFixed(2));
    document.getElementById("monthlyRoadtaxResult").innerHTML = "Monthly Roadtax: RM" + formatNumber(monthlyRoadtax.toFixed(2));
    document.getElementById("fuelCostResult").innerHTML = "Fuel Cost: RM" + formatNumber(fuelCost.toFixed(2));
    document.getElementById("totalCarMonthlyPaymentResult").innerHTML = "Total Car Monthly Payment: RM" + formatNumber(totalCarMonthlyPayment.toFixed(2));
}

// Calculate monthly payment
function calculateMonthlyPayment(carPrice, downPayment, loanTenure, interestRate) {
    // Calculate loan amount correctly by subtracting down payment from car price
    var loanAmount = carPrice - downPayment;

    // Convert annual interest rate to monthly rate and term to months
    var monthlyInterestRate = interestRate / 12 / 100; // Convert interest rate to decimal
    var months = loanTenure * 12;

    // Calculate monthly payment using the amortization formula
    var numerator = loanAmount * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, months);
    var denominator = Math.pow(1 + monthlyInterestRate, months) - 1;
    var monthlyPayment = numerator / denominator;

    return monthlyPayment; // Return the monthly payment
}

// Calculate monthlyInsurance
function calculateMonthlyInsurance(annualInsurance) {
    var monthlyInsurance = annualInsurance / 12;
    return monthlyInsurance;
}

// Calculate monthlyRoadtax
function calculateMonthlyRoadtax(annualRoadTax) {
    var monthlyRoadtax = annualRoadTax / 12;
    return monthlyRoadtax; 
}

// Calculate fuelCost
function calculateFuelCost(estimatedDistance, fuelConsumption) {
    var fuelCost = (estimatedDistance / fuelConsumption) * 2.05;
    return fuelCost; 
}

// Add event listener to the calculate button
document.getElementById('calculate-button').addEventListener('click', calculateLoan);

// Set buttons as toggle
document.addEventListener('DOMContentLoaded', function() {
    // Find all buttons to be set as toggle
    var downPaymentButtons = document.querySelectorAll('.down_payment-btn');
    var loanTenureButtons = document.querySelectorAll('.loan_tenure-btn');

    // Attach click event listener to each button
    downPaymentButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove 'selected' class from all buttons
            downPaymentButtons.forEach(function(btn) {
                btn.classList.remove('selected');
            });

            // Add 'selected' class to the clicked button
            this.classList.add('selected');
        });
    });

    // Attach click event listener to each button
    loanTenureButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove 'selected' class from all buttons
            loanTenureButtons.forEach(function(btn) {
                btn.classList.remove('selected');
            });

            // Add 'selected' class to the clicked button
            this.classList.add('selected');
        });
    });
});

// Set the down_payment buttons as input
document.addEventListener('DOMContentLoaded', function() {
    // Find all down payment buttons
    var downPaymentButtons = document.querySelectorAll('.down_payment-btn');
    var downPaymentInput = document.getElementById('down_payment');

    // Attach click event listener to each button
    downPaymentButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove 'selected' class from all buttons
            downPaymentButtons.forEach(function(btn) {
                btn.classList.remove('selected');
            });

            // Add 'selected' class to the clicked button
            this.classList.add('selected');

            // Set the value of the hidden input field based on the button clicked
            var carPrice = parseFloat(document.getElementById('car_price').value);
            var downPaymentPercentage = parseFloat(this.value);
            var calculatedDownPayment = carPrice * downPaymentPercentage;
            downPaymentInput.value = calculatedDownPayment.toFixed(2);
        });
    });
});

// Set the loan_tenure buttons as input
document.addEventListener('DOMContentLoaded', function() {
    // Find all loan tenure buttons
    var loanTenureButtons = document.querySelectorAll('.loan_tenure-btn');
    var loanTenureInput = document.getElementById('loan_tenure');

    // Attach click event listener to each button
    loanTenureButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove 'selected' class from all buttons
            loanTenureButtons.forEach(function(btn) {
                btn.classList.remove('selected');
            });

            // Add 'selected' class to the clicked button
            this.classList.add('selected');

            // Set the value of the input field based on the button clicked
            loanTenureInput.value = this.value;
        });
    });
});

</script>
</html>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Investment Loan Calculator</title>
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/calculators.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel="stylesheet">

        <!-- Styles -->
        <style>
/* Dropdown container */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown button */
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  width: 200px;
  border-radius: 20px;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of links on hover */
.dropdown-content a:hover {
  background-color: #f1f1f1;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

.investment_tenure-btn {
    width: 70px;
    height: 30px;
    border: none;
    border-radius: 10%;
    background-color: #ccc;
    color: #000000;
    font-size: 14px;
    cursor: pointer;
    display: inline-block;
}

.investment_tenure-btn.selected {
    color: #fff;
    background-color: #4CAF50; /* Green color */
}
        </style>
    </head>

    <body class="background-image" style="background-image: url('images/cold.jpg');">
    <x-navigation :pageTitle="$pageTitle" />

    <div class="loan-container">
    <b><h2>Investment Loan Calculator</h2></b><br>
    <form id="loan-form" method="POST" action="{{ route('save-investment') }}">
        @csrf <!-- CSRF Token -->

        <div class="form-group">    
            <b><label for="investment_type">Investment Type: &nbsp;</label></b>
            <input type="hidden" id="investment_type" name="investment_type">
            <div class="dropdown">
                <button id="dropbtn" class="dropbtn">Choose One</button>
                <div class="dropdown-content">
                    <a href="#" onclick="setItem('Unit Trust - ASB', 4.25)">Unit Trust - ASB</a>
                    <a href="#" onclick="setItem('Unit Trust - Tabung Haji', 3.1)">Unit Trust - Tabung Haji</a>
                    <a href="#" onclick="setItem('Fixed Deposit', 0)">Fixed Deposit</a>
                    <a href="#" onclick="setItem('Gold', 0)">Gold</a>
                    <a href="#" onclick="setItem('Others', 0)">Others</a>
                </div>
            </div>   
        </div>

        <div class="form-group">
            <b><label for="investment_amount">Initial Investment Amount: RM &nbsp;</label></b>
            <input type="text" id="investment_amount" name="investment_amount" required>
        </div>
        <div class="form-group">
            <b><label for="monthly_contribution">Monthly Contribution: RM &nbsp;</label></b>
            <input type="text" id="monthly_contribution" name="monthly_contribution" required>
        </div>
        <div class="form-group">
            <b><label for="investment_tenure">Investment Tenure: &nbsp; </label></b>
        </div>
        <div id="investment_tenure-buttons">
            <button type="button" class="investment_tenure-btn" value="1">1 </button>
            <button type="button" class="investment_tenure-btn" value="3">3 </button>
            <button type="button" class="investment_tenure-btn" value="5">5 </button>
            <button type="button" class="investment_tenure-btn" value="10">10 </button>
            <button type="button" class="investment_tenure-btn" value="15">15 </button>
            <button type="button" class="investment_tenure-btn" value="20">20 </button>
            <button type="button" class="investment_tenure-btn" value="25">25 </button>
            <button type="button" class="investment_tenure-btn" value="30">30 </button>
        </div>
        <input type="hidden" id="investment_tenure" name="investment_tenure" value=""> <br>
    
        <div class="form-group">
            <b><label for="annual_return">Annual Return: &nbsp;</label></b>
            <input type="text" id="annual_return" name="annual_return" required> &nbsp;
            <b>%</b>
        </div>
        <b><div id="TotalReturnResult"></div><b><br>
        <b><div id="TotalMonthlyContributionResult"></div><b><br>
        <input type="hidden" id="TotalReturnResultInput" name="TotalReturnResult">
        <button class="btn" type="button" id="calculate-button">Calculate</button>
        <button class="btn" type="submit">Save</button>  
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
document.getElementById('calculate-button').addEventListener('click', calculateInvestment);

function calculateInvestment() {
    var startingAmount = parseFloat(document.getElementById('investment_amount').value);
    var monthlyContribution = parseFloat(document.getElementById('monthly_contribution').value);
    var investmentTenure = parseFloat(document.getElementById('investment_tenure').value);
    var annualReturn = parseFloat(document.getElementById('annual_return').value) / 100; // Convert annual return to decimal

    if (isNaN(startingAmount) || isNaN(monthlyContribution) || isNaN(investmentTenure) || isNaN(annualReturn)) {
        Swal.fire({
            title: 'Error',
            text: 'Please enter valid numeric values!',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'OK',
        });
        return;
    }

    var futureValue = calculateFutureValue(startingAmount, annualReturn, investmentTenure, monthlyContribution);
    var totalContributions = monthlyContribution * investmentTenure * 12;
    var totalInterest = futureValue - totalContributions;

    document.getElementById("TotalReturnResult").innerHTML = "End Balance After " + investmentTenure + " Years: RM" + futureValue.toFixed(2);
    document.getElementById("TotalMonthlyContributionResult").innerHTML = "Total Interest Earned: RM" + totalInterest.toFixed(2);
    document.getElementById("TotalReturnResultInput").value = futureValue.toFixed(2);
}

var investmentTenureButtons = document.querySelectorAll('.investment_tenure-btn');
investmentTenureButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        investmentTenureButtons.forEach(function(btn) {
            btn.classList.remove('selected');
        });
        this.classList.add('selected');
        document.getElementById('investment_tenure').value = this.value;
    });
});

function setItem(item, annualReturn) {
    document.getElementById('dropbtn').innerHTML = item;
    document.getElementById('annual_return').value = annualReturn;
    document.getElementById('investment_type').value = item;
}

function calculateFutureValue(PV, r, t, PMT) {
    // Calculate the future value of monthly contributions compounded annually
    let FV = 0;

    for (let i = 1; i <= t * 12; i++) {
        FV += PMT * Math.pow(1 + r, (t * 12 - i + 1) / 12);
    }
    
    return FV;
}
</script>

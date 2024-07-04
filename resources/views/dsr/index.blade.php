<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DSR</title>
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/calculators.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel="stylesheet">

        <!-- Styles -->
        <style>
.dsr-container {
    width: 100%;
    height: 20px;
    background-color: #f2f2f2;
    border-radius: 10px;
    margin-bottom: 10px;
}

#dsr-bar {
    height: 100%;
    border-radius: 10px;
    background-color: #695CFE;
    width: 0; /* Initial width */
    transition: width 0.5s; /* Smooth transition */
}


        </style>
    </head>

    <body class="background-image" style="background-image: url('images/cold.jpg');">
    <x-navigation :pageTitle="$pageTitle" />

    <div class="loan-container">
    <h2>Debt Service Ratio Calculator</h2><br>
    <form id="loan-form" method="POST" action="{{ route('save-dsr') }}">
    @csrf
    <div class="form-group">
        <b><label for="net_income">Monthly Net Income: RM &nbsp;</label></b>
        <input type="number" id="net_income" name="net_income" required>
    </div>
    <div class="form-group">
        <b><label for="monthly_commitment">Total Monthly Commitment: RM &nbsp;</label></b>
        <input type="number" id="monthly_commitment" name="monthly_commitment" required>
    </div>
    <div class="dsr-container">
        <div id="dsr-bar"></div>
    </div>
    <b><div id="result"></div></b><br>
    <input type="hidden" name="userID" value="{{ auth()->id() }}">
    <input type="hidden" name="dsr" id="dsr-value">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
document.getElementById('calculate-button').addEventListener('click', calculateLoan);

function calculateLoan() {
    var netIncome = parseFloat(document.getElementById('net_income').value);
    var monthlyCommitment = parseFloat(document.getElementById('monthly_commitment').value);

    if (isNaN(netIncome) || isNaN(monthlyCommitment)) {
        Swal.fire({
            title: 'Error',
            text: 'Please enter valid numeric values!',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'OK',
            heightAuto: false
        });
        return;
    }

    var dsr = calculateDSR(netIncome, monthlyCommitment);

    // Update DSR bar width
    var dsrBar = document.getElementById('dsr-bar');
    dsrBar.style.width = dsr + '%';

    // Change background color based on DSR value
    if (dsr >= 0 && dsr <= 29) {
        dsrBar.style.backgroundColor = 'blue';
    } else if (dsr >= 30 && dsr <= 40) {
        dsrBar.style.backgroundColor = 'green';
    } else if (dsr >= 41 && dsr <= 50) {
        dsrBar.style.backgroundColor = 'yellow';
    } else if (dsr >= 51 && dsr <= 100) {
        dsrBar.style.backgroundColor = 'red';
    }

    document.getElementById("result").innerHTML = "Debt Service Ratio: " + dsr.toFixed(2) + "%";
    document.getElementById("dsr-value").value = dsr.toFixed(2); // Update the hidden field value
}

function calculateDSR(net_income, monthly_commitment) {
    return (monthly_commitment / net_income) * 100;
}

    </script>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <!-- Fonts -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <!-- Styles -->
        <style>
            body {
}

h1 {
    margin-left: 500px;
    color: black;
}

.container {
    width: 1000px;
    height: 1000px;
    margin: auto;
    max-width: 90vw;
    text-align: center;
    padding-top: 100px;
    transition: transform .5s;
    margin-left: 400px;
}

svg {
    width: 30px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
}

.title {
    font-size: 35px;
    font-weight: 150px;
}

.data-container .item img {
    width: 80%;
    filter: drop-shadow(0 20px 10px #0009);
}

.data-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    height: 200px;
}

.data-container .item {
    background: #FFFFFF;
    padding: 20px;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateX(-100%);
    animation: slide-in 0.3s forwards;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.data-container .item:hover {
    transform: translateY(-10px) translateX(0);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
}

.data-container .item:nth-child(1) {
    animation-delay: 0.2s;
}

.data-container .item:nth-child(2) {
    animation-delay: 0.4s;
}

.data-container .item:nth-child(3) {
    animation-delay: 0.6s;
}

.data-container .item:nth-child(4) {
    animation-delay: 0.8s;
}

.data-container .item:nth-child(5) {
    animation-delay: 1s;
}

.data-container .item h2 {
    font-weight: 25px;
    font-size: 25px;
    background: linear-gradient(45deg, #ff6b6b, #f94d6a, #c752d0, #7b60d5);
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    color: transparent;
}

.data-container .item .price {
    letter-spacing: 1px;
    font-size: 17px;
}

/* Define the slide-in keyframes */
@keyframes slide-in {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.dsr-container {
    width: 100%;
    height: 20px;
    background-color: #B8B5B5;
    border-radius: 10px;
    margin-bottom: 10px;
}

#dsr-bar {
    height: 100%;
    border-radius: 10px;
    background-color: #695CFE;
    width: 0; /* Initial width */
    transition: width 0.5s ease-in-out; /* Smooth transition */
}

.dsr-filled {
    width: 100%;
}

/* Summary Container*/
.container {
    width: 1000px;
    height: 1000px;
    margin: auto;
    max-width: 90vw;
    text-align: center;
    padding-top: 100px;
    transition: transform .5s;
    margin-left: 400px;
}
.summary-container .item img {
    width: 80%;
    filter: drop-shadow(0 20px 10px #0009);
}

.summary-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    height: 200px;
    width: 4000px;
}

.summary-container .item {
    background: #FFFFFF;
    padding: 20px;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateX(-100%);
    animation: slide-in 0.3s forwards;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.summary-container .item:hover {
    transform: translateY(-10px) translateX(0);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
}

.summary-container .item h2 {
    font-weight: 25px;
    font-size: 25px;
    background: linear-gradient(45deg, #ff6b6b, #f94d6a, #c752d0, #7b60d5);
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    color: transparent;
}

.summary-container .item .price {
    letter-spacing: 1px;
    font-size: 17px;
}
        </style>
    </head>
    <x-navigation page-title="{{ $pageTitle }}" />
    <div class="container">
        <header>
            <div class="title">My Dashboard</div>
        </header>
        <div class="data-container">
            @if(isset($dsr))
            <div class="item">
                <h2>{{ $dsr }}%</h2>
                <div class="price">Debt Service Ratio</div><br><br>
                    <div class="dsr-container">
                    <div id="dsr-bar"></div>
                </div>
            </div>
        
            @else
            <div class="item">
                <h2>0%</h2>
                <div class="price">Debt Service Ratio</div>
            </div>
            @endif

            <div class="item">
            <h2>RM{{ number_format($netWorth, 2) }}</h2>
                <div class="price">Net Worth</div>
            </div>

            @if(auth()->check())
        <div class="item">
            <h2>RM{{ number_format($totalAssetsAmount, 2) }}</h2>
            <div class="price">Total Assets</div>
        </div>
    @else
        <div class="item">
            <h2>RM0</h2>
            <div class="price">Total Assets</div>
        </div>
    @endif
            
            @if(isset($totalLiabilitiesAmount))
            <div class="item">
                <h2>RM{{ number_format($totalLiabilitiesAmount, 2) }}</h2>
                <div class="price">Total Liabilities</div>
            </div>

            @else
            <div class="item">
                <h2>RM0</h2>
                <div class="price">Total Liabilities</div>
            </div>
            @endif
            </div><br>

            <div class="summary-container">
                <div class="item">
                    <div class="price">Summary</div>
                    <h2>RM1,400,000</h2>
                </div> 
        </div>
    </div>

  <script>
    // Update DSR bar width
    document.addEventListener("DOMContentLoaded", function() {
        var dsr = {{ $dsr ?? 0 }}; // Default to 0 if $dsr is not set
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

        // Trigger reflow to start transition
        void dsrBar.offsetWidth;
        dsrBar.style.width = dsr + '%';
    });
</script>
</body>
</html>

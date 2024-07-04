<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Assets</title>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calculators.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel="stylesheet">

    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        /* Table container styles */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Table styles */
        table {
            width: 80%;
            margin-left: 150px;
            margin-right: 150px;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            background-color: #ffffff;
            border: 1px solid #dddddd;
        }

        /* Table header styles */
        th {
            background-color: #f5f5f5;
            color: #333333;
            padding: 12px 15px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #dddddd;
        }

        /* Table row styles */
        tr {
            border-bottom: 1px solid #dddddd;
        }

        /* Table row hover effect */
        tr:hover {
            background-color: #f9f9f9;
        }

        /* Table data styles */
        td {
            padding: 10px 15px;
            color: #666666;
        }

        /* Alternate row colors for better readability */
        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Responsive table styles */
        @media screen and (max-width: 600px) {
            table {
                overflow-x: auto;
                display: block;
            }
            th, td {
                min-width: 100px;
            }
        }

        /* Overlay styles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
            z-index: 1000; /* Ensure the overlay is on top of everything */
            display: none; /* Initially hidden */
        }
    </style>
</head>

<body class="background-image" style="background-image: url('images/cold.jpg');">
    <x-navigation :pageTitle="$pageTitle" />

    <div class="overlay"></div>
    <div class="assets-table-container">
    <table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Asset Type</th>
            <th>Price</th>
            <th>Interest Rate</th>
            <th>Loan Tenure</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($assets as $index => $asset)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $asset->assets_type }}</td>
                <td>RM {{ $asset->assets_amount }}</td>
                <td>{{ $asset->assets_interest_rate }}%</td>
                <td>{{ $asset->assets_loan_tenure }} Years</td>
                <td>
                <form id="delete-form-{{ $asset->assetsID }}" action="{{ route('assets.destroy', $asset->assetsID) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $asset->assetsID }})" style="border: none; background: none; cursor: pointer;">
                                <i class='bx bxs-trash-alt bx-sm'></i>
                            </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No assets found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
    </div>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Add click event listener to info icon
    document.querySelector('.info-icon').addEventListener('click', function() {
        // Display overlay
        document.querySelector('.overlay').style.display = 'block';
        // Display SweetAlert
        Swal.fire({
            title: 'Expected Return Meaning',
            text: 'Expected Return Of Investment (ROI) Over The Loan/Investment Tenure.',
            icon: 'info',
            confirmButtonText: 'OK'
        }).then(() => {
            // Hide overlay when SweetAlert is closed
            document.querySelector('.overlay').style.display = 'none';
        });
    });

    function confirmDelete(assetID) {
        Swal.fire({
            heightAuto: false,
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + assetID).submit();
            }
        })
    }
</script>

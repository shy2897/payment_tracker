<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monthly Report - {{ date("F Y", mktime(0, 0, 0, $month, 1, $year)) }}</title>
    <!-- Include Bootstrap CSS from a CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            padding: 20px; /* Add some padding for a better layout */
        }
        .container {
            max-width: 800px; /* Control the maximum width of the content */
            margin: 0 auto; /* Center the container */
        }
        
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3 class="text-center">Monthly Report - {{ date("F Y", mktime(0, 0, 0, $month, 1, $year)) }}</h3>
        </br>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Invoice No.</th>
                    <th>Invoice Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($changes as $change)
                <tr>
                    <td>{{ $change->invoice_no }}</td>
                    <td>{{ date('d/m/Y', strtotime($change->invoice_date)) }}</td>
                    <td>{{ $change->description }}</td>
                    <td>{{ $change->currency }} {{ $change->amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS and jQuery if needed -->

</body>
</html>

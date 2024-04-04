<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $month }} - {{ $year }}</title>

    <!-- Include Bootstrap CSS from a CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        /* Custom CSS */
        body {
            padding: 5px; /* Add some padding for a better layout */
        }
        .container {
            max-width: 100%; /* Control the maximum width of the content */
            margin: 0 auto; /* Center the container */
        }
        
    </style>
</head>
<body>
    <div class="row">
            <div class="container mt-1">
                <h3 class="text-center"> {{ $month }} - {{ $year }} </h3>
                </br>
        
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Status</th>
                            <th>Invoice No.</th>
                            <th>Invoice Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->status}}</td>
                            <td>{{ $product->invoice_no }}</td>
                            <td>{{ date('d/m/Y', strtotime($product->invoice_date)) }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->currency }} {{ $product->amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>

    <!-- Include Bootstrap JS and jQuery if needed -->

</body>
</html>

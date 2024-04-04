<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>New Approval Request</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .card {
            border: 2px solid #ff0000;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 50px; /* Adjust the padding value as needed */
        }

        .card-title {
            color: #ff0000;
        }

        ul.list-group li {
            font-size: 14px;
            border: none;
            padding: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Project Payment Tracker</h2>
                        <h3 class="card-title">Rejected Request</h3>
                        <p>Hello,</p>
                        <p class="font-weight-bold">Reason for rejection: {{ $change->remarks }}</p>
                        <p>The request for approval had been rejected with the following details:</p>
                        <ul class="list-group">
                            <li class="list-group-item">Invoice No: {{ $change->invoice_no }}</li>
                            <li class="list-group-item">Description: {{ $change->description }}</li>
                            <li class="list-group-item">Invoice Date: {{ $change->invoice_date }}</li>
                            <li class="list-group-item">Currency: {{ $change->currency }}</li>
                            <li class="list-group-item">Amount: {{ $change->amount }}</li>
                        </ul>
                        <p>Please review and take necessary action.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>
</body>
</html>

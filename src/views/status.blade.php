<!-- resources/views/paymentStatus.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,400,700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            font-family: 'Lato', sans-serif;
            color: #333;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            max-width: 600px;
            margin: 20px;
            animation: fadeIn 1s ease-in-out;
        }
        .title {
            font-size: 48px;
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .message {
            font-size: 20px;
            line-height: 1.6;
        }
        .message div {
            margin-bottom: 10px;
        }
        .status-success {
            color: #28a745;
            font-weight: 600;
        }
        .status-failed {
            color: #dc3545;
            font-weight: 600;
        }
        .btn-print {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="title">Payment Status</div>
            <div class="message">
                @if(is_array($status))
                    <div class="{{ $status['result'] == 'SUCCESS' ? 'status-success' : 'status-failed' }}">
                        Result: {{ $status['result'] }}
                    </div>
                    <div>Auth: {{ $status['auth'] }}</div>
                    <div>Reference: {{ $status['ref'] }}</div>
                    <div>AVR: {{ $status['avr'] }}</div>
                    <div>Postdate: {{ $status['postdate'] }}</div>
                    <div>TranID: {{ $status['tranid'] }}</div>
                    <div>TrackID: {{ $status['trackid'] }}</div>
                    <div>PayID: {{ $status['payid'] }}</div>
                    <div>Amount: {{ $status['amt'] }}</div>
                    <div>Auth Response Code: {{ $status['authRespCode'] }}</div>
                @else
                    <div class="status-failed">{{ $status }}</div>
                @endif
            </div>
            <button type="button" onclick="printDiv('container')" class="btn btn-print mt-4">
                Print Receipt
            </button>
        </div>
    </div>

    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>

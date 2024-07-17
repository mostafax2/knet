<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment {{ !empty($data['result']) ? $data['result'] : 'Failed' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,400,700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            font-family: 'Lato', sans-serif;
        }
        .container {
            text-align: center;
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h6 {
            color: #28a745;
            font-weight: 700;
        }
        .receipt {
            text-align: left;
        }
        .receipt h5 {
            font-size: 1rem;
            color: #343a40;
        }
        .receipt span {
            color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h6 class="my-4 text-capitalize text-center">
            Payment {{ !empty($data['result']) ? $data['result'] : 'Failed' }}
        </h6>
        <div id="container" class="receipt p-4">
            <p class="fs-4 text-dark text-center mb-4 font-weight-bold">Payment Receipt</p>
            <div>
                <h5 class="mb-4">
                    Payment ID:
                    <span>{{ $data['paymentid'] }}</span>
                </h5>
                <h5 class="mb-4">
                    Payment Amount:
                    <span>{{ $data['amt'] }} {{ __('main.kwd') }}</span>
                </h5>
                <h5 class="mb-4">
                    Date:
                    <span>{{ date('y-m-d') }}</span>
                </h5>
                <h5 class="mb-4">
                    Result:
                    <span>{{ !empty($data['result']) ? $data['result'] : '----' }}</span>
                </h5>
                <h5 class="mb-4">
                    Transaction ID:
                    <span>{{ !empty($data['tranid']) ? $data['tranid'] : '----' }}</span>
                </h5>
                <h5 class="mb-4">
                    Auth:
                    <span>{{ !empty($data['auth']) ? $data['auth'] : '----' }}</span>
                </h5>
                <h5 class="mb-4">
                    Track ID:
                    <span>{{ !empty($data['trackid']) ? $data['trackid'] : '----' }}</span>
                </h5>
                <h5 class="mb-3">
                    Reference Number:
                    <span>{{ !empty($data['ref']) ? $data['ref'] : '----' }}</span>
                </h5>
            </div>
        </div>
        <h5 class="text-center fs-5 mb-3 text-secondary">
            Take a screenshot for your reference
        </h5>
        <button type="button" onclick="printDiv('container')" class="btn btn-secondary text-capitalize mb-4">
            Print
        </button>
    </div>

    <script type="text/javascript">
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

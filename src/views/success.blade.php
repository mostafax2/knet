<title> Payment Successful</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">


<div class="container">
    <h6 class="my-4 text-capitalize text-success fw-bold text-center">
        Payment Successful
    </h6>
    <div id="container">
        <p class="fs-14 text-dark text-center mb-4 fw-bolder">Payment Receipt</p>

        <div class="shadow p-3 px-md-5 py-md-4 rounded mb-3 w-50 mx-auto mb-4">
            <h5 class="fs-14 mt-3 mb-4">
                Payment ID:
                <span class="fw-bold"> {{ $data['paymentid'] }}</span>
            </h5>
            <h5 class="fs-14 mb-4">
                Payment Amount:
                <span class="fw-bold">{{ $data['amt'] }} {{ __('main.kwd') }}</span>
            </h5>
            <h5 class="fs-14 mb-4">
                Date:
                <span class="fw-bold">{{ date('y-m-d') }}</span>
            </h5>
            <h5 class="fs-14 mb-4">
                Result:
                <span class="fw-bold">{{ !empty($data['result']) ? $data['result'] : '----' }}</span>
            </h5>
            <h5 class="fs-14 mb-4">
                Transaction ID:
                <span class="fw-bold">{{ !empty($data['tranid']) ? $data['tranid'] : '----' }}</span>
            </h5>
            <h5 class="fs-14 mb-4">
                Auth:
                <span class="fw-bold">{{ !empty($data['auth']) ? $data['auth'] : '----' }} </span>
            </h5>
            <h5 class="fs-14 mb-4">
                Track ID:
                <span class="fw-bold">{{ !empty($data['trackid']) ? $data['trackid'] : '----' }} </span>
            </h5>
            <h5 class="fs-14 mb-3">
                Reference Number:
                <span class="fw-bold">{{ !empty($data['ref']) ? $data['ref'] : '----' }} </span>
            </h5>
        </div>
    </div>
    <h5 class="text-center fs-14 mb-3 text-secondary">
        Take a screenshot for your reference
    </h5>
    <button type="button" onclick="printDiv('container')"
        class="btn btn-secondary d-flex mb-4 text-capitalize mx-auto">
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


<style>
    html,
    body {
        height: 100%;
    }

    body {
        margin: 0;
        padding: 0;
        width: 100%;
        display: table;
        font-weight: 200;
        font-family: 'Lato';
    }

    .container {
        /* text-align: center; */
        display: table-cell;
        vertical-align: middle;
    }

    .content {
        /* text-align: center; */
        display: inline-block;
    }

    .title {
        font-size: 96px;
    }
</style>

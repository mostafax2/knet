<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Form Example</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Input Data Form</h2>
        <form id="dataForm" action="{{url('knet/init')}}" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
                <div class="invalid-feedback">
                    The amount field is required.
                </div>
            </div>
            <div class="form-group">
                <label for="track_id">Track ID</label>
                <input type="text" class="form-control" id="track_id" name="track_id" required>
                <div class="invalid-feedback">
                    The track id field is required.
                </div>
            </div>
            <div class="form-group">
                <label for="udf1">UDF1</label>
                <input type="text" class="form-control" id="udf1" name="udf1" required>
                <div class="invalid-feedback">
                    The udf1 field is required.
                </div>
            </div>
            <div class="form-group">
                <label for="udf2">UDF2</label>
                <input type="text" class="form-control" id="udf2" name="udf2" required>
                <div class="invalid-feedback">
                    The udf2 field is required.
                </div>
            </div>
            <div class="form-group">
                <label for="udf3">UDF3</label>
                <input type="text" class="form-control" id="udf3" name="udf3" required>
                <div class="invalid-feedback">
                    The udf3 field is required.
                </div>
            </div>
            <div class="form-group">
                <label for="udf4">UDF4</label>
                <input type="text" class="form-control" id="udf4" name="udf4" required>
                <div class="invalid-feedback">
                    The udf4 field is required.
                </div>
            </div>
            <div class="form-group">
                <label for="udf5">UDF5</label>
                <input type="text" class="form-control" id="udf5" name="udf5" required>
                <div class="invalid-feedback">
                    The udf5 field is required.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Custom Bootstrap validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>

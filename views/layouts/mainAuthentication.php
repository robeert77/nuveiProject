<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <section class="container my-5">
        <?php if ($_SESSION['success_registration']) { ?>
            <div class="row">
                <div class="alert alert-success col-sm-8" role="alert">
                    <h3 class="text-capitalize mt-1">Success!</h3>
                    <?php echo $_SESSION['success_registration']; ?>
                </div>
            </div>
        <?php
        unset($_SESSION['success_registration']);
        } ?>

        <div class="row">
            <div class="col">
                <a class="btn btn-primary" href="/<?php echo isset($registerURL) ? $registerURL : CORE_PATH; ?>" role="button">Register</a>
            </div>
            <div class="col">
                <a class="btn btn-primary disabled" href="#" role="button" aria-disabled="true">Log in</a>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

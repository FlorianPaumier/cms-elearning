<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ title }}</title>

    <meta lang="fr">

    <!-- Custom fonts for this template-->
<<<<<<< HEAD
    <link rel="stylesheet" href="assets/dist/fontawesome/css/all.css">
<<<<<<< HEAD
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/styles/main.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="assets/styles/login.css">

=======
    <link rel="stylesheet" href="/assets/styles/dashboard.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/assets/styles/admin/main.css" rel="stylesheet" type="text/css">
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
=======
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/styles/css/sb-admin-2.min.css" rel="stylesheet">
>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c

</head>

<body id="page-top">

@include(admin/partials/sidebar)

<<<<<<< HEAD
<?php
    if($session["user"]):
?>
        {{ @View/partials/sidebar|include }}
<?php endif; ?>

@section(body)

{{ @View/partials/footer|include }}

<script src="assets/scripts/login.js"></script>
=======
@include(admin/partials/titlebar)

@section(body)


@include(partials/modal)

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>

<script  src="/assets/scripts/core/observer.js"></script>

@section(javascripts)
<<<<<<< HEAD
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
=======

@include(admin/partials/footer)
>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
</body>
</html>


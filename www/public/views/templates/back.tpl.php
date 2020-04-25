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
    <link rel="stylesheet" href="assets/dist/fontawesome/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/assets/styles/admin/main.css" rel="stylesheet">

</head>

<body id="page-top">

@include(admin/partials/sidebar)

@include(admin/partials/titlebar)

@section(body)


@include(partials/modal)

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>

<script  src="/assets/scripts/core/observer.js"></script>

@section(javascripts)

@include(admin/partials/footer)

</body>
</html>

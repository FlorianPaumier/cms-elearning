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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/styles/frontend/main.css" rel="stylesheet">
    @section(style)
</head>

<body id="page-top">

@include(partials/header)

<main>
    @section(body)
</main>

@include(partials/modal)
@include(partials/footer)

<script src="/assets/scripts/global.js"></script>
<script src="/assets/scripts/header.js"></script>
@section(javascript)
</body>
</html>


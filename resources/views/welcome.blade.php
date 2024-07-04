<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calculators.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel="stylesheet">
    <!-- Styles -->
    <style>
    </style>
</head>
<body class="background-image" style="background-image: url('images/cold.jpg');">
<x-navigation :pageTitle="$pageTitle" /> <!-- Pass the $pageTitle variable to the x-navigation component -->
</body>
</html>

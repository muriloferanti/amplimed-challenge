<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Weather Challenge</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body class="antialiased">
        <header>
            <div class="content">
                <ul>
                    <li>
                        <a href="/"> <i class="fas fa-home"></i>Início</a>
                    </li>
                    <li>
                        <a href="/weather-records"><i class="fas fa-exchange-alt"></i>Comparar</a>
                    </li>
                </ul>
                <div id="global-weather"></div>
            </div>
        </header>



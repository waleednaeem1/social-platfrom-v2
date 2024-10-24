<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Devsinc</title>

        @include('partials._head')
    </head>
    <x-app-layout>
        <body class="my-5">
            <div class="container-fluid container">
                <div class="row">
                    <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                        <h3 class="text-primary text-center mb-3">Our Vision</h3>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        {{-- <h4 class="card-title">What is Devsinc?</h4> --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        While Devsinc has been growing in a tech landscape for more than a decade, I recognize the challenges businesses face in managing digital systems. As the world transforms into a global village, our vision goes beyond. We aim to reimagine IT solutions into smart, agile, and AI-enhanced digital assets.
                                    </p>
                                    <p>
                                        Our commitment is to lead in the digital transformation, providing globally agile services to clients in different countries. In these times of recent changes, our ever-growing pool of resilient tech heads drives the IT world toward a future where innovation meets the demands of an ever-evolving digital era.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </x-app-layout>
</html>
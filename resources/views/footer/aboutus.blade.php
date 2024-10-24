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
                        <h3 class="text-primary text-center mb-3">About Us</h3>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        {{-- <h4 class="card-title">What is Devsinc?</h4> --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Devsinc helps start-ups, SMEs and enterprises grow their business
                                    </p>
                                    <p>
                                        We’ve been helping customers since 2009 and take pride in delivering high-quality custom services designed to help you build, grow, and revolutionize your industry.
                                    </p>
                                    <p>
                                        Help companies deliver innovative technology solutions to power their growth by unlocking access to passionate and experienced engineers and solution providers
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
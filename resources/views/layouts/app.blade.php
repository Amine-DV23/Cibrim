<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />


    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <!-- Spinner -->
    <div id="spinner"></div>
    <!-- Success Message -->
    <div class="success-message" id="success-message">
        Data added successfully!
    </div>

    <!-- Error Message -->
    <div class="error-message" id="error-message">
        Failed to add data. Please try again.
    </div>

    @include('partials.header')
    <main style="flex: 1;">
        @yield('content')
    </main>
    @include('partials.footer')
    <script src="js/main.js"></script>
</body>

</html>

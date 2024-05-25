<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="bg-gray-200">
    @yield('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <@vite('resources/js/app.js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>  
    <script>
        // pesan ditoaster
        @if(session()->has('success'))
            toastr.success('{{ session('success') }}', 'SUCCESS!'); 
        @elseif(session()->has('error'))
            toastr.error('{{ session('error') }}', 'ERROR!'); 
        @endif
    </script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Link to Montserrat font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Link to Merriweather font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <!-- Link to Playfair Display font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Sweet Alert CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    {{-- Styles --}}
    <style>
        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 8px;
            background-color: #FBCD01;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #FBCD01, black);
            border-radius: 10px;
        }

        body {
            font-family: 'Montserrat', sans-serif; 
        }

        #sidebar {
            margin-top: -100%;
            transition: all 1s ease;
        }

        #sidebar.active {
            margin-top: 0%;
        }
    </style>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    {{-- Swal --}}
    @if (Session::has('success'))
        <script>
            Swal.fire({
                title: "Success!",
                text: "{{ Session::get('success') }}",
                icon: "success"
            });
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                title: "Ooops!",
                text: "{{ Session::get('error') }}",
                icon: "error"
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                title: "Ooops!",
                text: "{{ $errors->first() }}",
                icon: "error"
            });
        </script>
    @endif

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Body --}}
    @yield('body')
    @yield('script')
    <script>
        $(function() {
            $('#hamburger').on('click', function() {
                console.log('active');
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>

</html>

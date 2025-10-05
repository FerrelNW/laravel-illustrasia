<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin</title>

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

        body {
            background-image: url('/assets/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        body {
            padding: 0;
            overflow-x: hidden;
            overflow-y: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 1vh;
            padding-bottom: 2vh;
        }

        .google-logo {
            width: 60px;
            padding-right: 20px;
        }

        .login-button a,
        login-container {
            user-select: none;
            background: rgb(0, 0, 0, 0.2);
            height: 80px;
            width: 400px;
            border-radius: 20px;
            font-size: 26px;
            border: none;
            color: white;
            cursor: pointer;
            transition: transform .25s;
            font-weight: bold;
            overflow: hidden;
            display: flex;
            justify-content: center;
            box-shadow: 0 0 3px lightyellow, 0 0 15px lightyellow, 0 0 20px lightyellow;
            align-items: center;
            transform: 0.3s ease;
        }

        .login-button a:hover {
            transform: scale(1.04);
        }

        @media screen and (min-width: 500px) and (max-width: 700px) {

            .login-button a {
                width: 350px;
                height: 60px;
                font-size: 24px;
            }

            .google-logo {
                width: 40px;
            }
        }

        @media screen and (max-width: 500px) {

            .login-container {
                padding-right: 2rem !important;
                padding-left: 2rem !important;
            }

            .login-button a {
                width: 280px;
                height: 50px;
                font-size: 20px;
            }

            .google-logo {
                width: 30px;
                padding-right: 10px;
            }

        }
    </style>
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

    <section class="login-container sm:space-y-10 space-y-3 bg-[#0000004d] sm:p-10 rounded-2xl backdrop-blur-sm p-5">
        <h1
            class="font-bold sm:text-6xl md:text-8xl text-5xl text-center bg-gradient-to-r from-yellow-500 to-cyan-500 text-transparent bg-clip-text">
            Admin Illustrasia</h1>
        <div class="login-button flex flex-col justify-center mx-auto">
            <a href="{{ route('admin.redirect') }}"><img src="{{ asset('assets/google.webp') }}" class="google-logo"> <span class="span1">Sign
                    In with Gmail</span></button>
                {{-- <a href="{{ route('user.auth', ['type' => 'admin']) }}"><img src="{{ asset('assets/Google.png') }}"
                    class="google-logo"> <span class="span1">Sign In with PCU Email</span></button> --}}
        </div>
    </section>
</body>

</html>

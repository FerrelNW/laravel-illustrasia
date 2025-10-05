<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Illustrasia</title>
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

        .highlight-text {
            font-family: 'Playfair Display', 'serif';
        }

        .thin {
            font-weight: 300;
        }

        @keyframes flick {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 100%;
            }

            100% {
                opacity: 0;
            }
        }

        @keyframes scale {
            0% {
                transform: scale(1, 1) translate(-70%, -70%);
                opacity: 0.8;
            }

            20% {
                transform: scale(1.4, 1.8) translate(-50%, -50%);
                opacity: 0.5;
            }

            40% {
                transform: scale(2, 2) translate(-20%, -50%);
                opacity: 0.2;
            }

            60% {
                transform: scale(1.1, 1.2) translate(-50%, -50%);
                opacity: 0.5;
            }

            80% {
                transform: scale(1, 1) translate(-50%, -20%);
                opacity: 0.7;
            }

            100% {
                transform: scale(1, 1) translate(-70%, -70%);
                opacity: 0.8;
            }
        }

        @keyframes scale2 {
            0% {
                transform: scale(2, 2);
                opacity: 0.5;
            }

            25% {
                transform: scale(1.9, 2.1);
                opacity: 0.4;
            }

            50% {
                transform: scale(2.7, 2.9);
                opacity: 0.1;
            }

            75% {
                transform: scale(2.5, 2.1);
                opacity: 0.5;
            }

            100% {
                transform: scale(2, 2);
                opacity: 0.5;
            }
        }


        .key {
            animation: flick .7s infinite;
        }

        .ele-icon {
            animation: scale 4s infinite;
        }

        .ele-icon-2 {
            animation: scale2 6s infinite
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

    <div class="w-full min-h-screen">
        <div class="w-full bg-[#FBCD01] min-h-screen flex flex-col z-10 justify-center items-center relative overflow-hidden">
            <div
                class="w-[400px] h-[400px] bg-[#DA9318] absolute top-0 left-0 rounded-full blur ele-icon border border-black">
            </div>
            <div
                class="w-[400px] h-[400px] bg-[#DA9318] absolute bottom-0 right-0 rounded-full blur ele-icon-2 border border-black">
            </div>
            <h1 class="block z-10 px-2 text-7xl text-white text-center font-bold mt-8"><span
                    class="thin drop-shadow-md">Welcome
                    to</span> <span class="brand text-black highlight-text italic tracking-wider"
                    id="brand">Illustrasia </span> <span class="ml-2 border border-black key"></span>
            </h1>
            <div class="grid grid-cols-12 mt-8 w-full z-10" id="role">
                <div class="col-span-12 md:col-span-6">
                    <div
                        class="w-[80%] md:w-[60%] m-8 ml-auto p-5 hover:bg-white shadow-xl rounded-3xl hover:shadow-2xl transition ease-in-out duration-300 bg-[#FBCD01] border border-white hover:border-none flex flex-col justify-center">
                        <h1 class="text-2xl md:text-3xl font-bold text-center mb-5 mt-3">Illustrator</h1>
                        <img src="{{ asset('assets/illustrator2.png') }}"
                            class="w-full h-[300px] object-contain rounded-md">
                        <a class="bg-black px-5 py-2 rounded shadow hover:shadow-lg hover:bg-yellow-500 hover:text-black hover:font-bold hover:scale-110 transition ease-in-out duration-300 inline-block mx-auto mt-5 text-white text-center"
                            href="{{ route('login.illustrator') }}">Enter</a>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <div
                        class="w-[80%] md:w-[60%] m-8 mr-auto p-5 hover:bg-white shadow-xl rounded-3xl hover:shadow-2xl transition ease-in-out duration-300 bg-[#FBCD01] border border-white hover:border-none flex flex-col justify-center">
                        <h1 class="text-2xl md:text-3xl font-bold text-center mb-5 mt-3">Customer</h1>
                        <img src="{{ asset('assets/customer.png') }}"
                            class="w-full h-[300px] object-contain rounded-md">
                        <a class="bg-black px-5 py-2 rounded shadow hover:shadow-lg hover:bg-yellow-500 hover:text-black hover:font-bold hover:scale-110 transition ease-in-out duration-300 inline-block mx-auto mt-5 text-white text-center"
                            href="{{ route('login.customer') }}">Enter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const brandEle = document.getElementById('brand');
        let brandName = 'Illustrasia';
        let idx = 0;
        let state = 0;
        let currentName = '';
        let freezeRound = 0;

        setInterval(() => {
            if (freezeRound > 0) {
                freezeRound--;
            } else if (state === 0) {
                currentName += brandName[idx];
                idx += 1;
                if (idx === brandName.length) {
                    idx = 0;
                    state = 1 - state;
                    freezeRound = 10;
                }
                brandEle.innerHTML = currentName;
            } else {
                currentName = currentName.slice(0, -1);
                if (currentName.length === 0) {
                    state = 1 - state;
                    freezeRound = 5;
                }
                brandEle.innerHTML = currentName;
            }
        }, 200);
    </script>
</body>

</html>

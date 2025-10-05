@extends('layouts.main')

@section('body')
    <div class="bg-yellow-100">
        <!-- Profile Card -->
        <div class="flex justify-center h-[calc(100vh-65px)]">
            <div class="bg-yellow-400 shadow-lg rounded-2xl max-w-sm w-full h-fit pt-12 pb-6 px-6 mt-16 flex flex-col">

                <!-- Profile Picture -->
                <div class="flex justify-center mb-4">
                    <div class="h-32 w-32 rounded-full overflow-hidden border-4 border-yellow-300 shadow-md">
                        <img src="{{ asset($user->profile_picture) }}"class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Name -->
                <h1 class="text-2xl font-bold text-yellow-900 text-center">{{ $user->name }}</h1>

                <!-- Email -->
                <p class="text-yellow-800 text-center mt-[-5px] text-lg">
                    {{ $user->email }}
                </p>

                <!-- Bio -->
                <p class="text-yellow-800 text-center mt-2 italic">
                    {{ $user->bio }}
                </p>

                <!-- Stats Section -->
                <div class="mt-4 flex justify-around text-center">
                    <div>
                        @if ($artCount > -1)
                            <p class="text-3xl font-bold text-purple-600">{{ $artCount }}</p>
                            <p class="text-yellow-800">Arts Listed</p>
                        @else
                            <p class="text-3xl font-bold text-purple-600">{{ $user->customer->purchase_count }}</p>
                            <p class="text-yellow-800">Arts Bought</p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col justify-center items-center">
                    @if ($openCommision)
                        <p class="mt-[30px] mb-2 text-sm font-bold italic text-indigo-500">Illustrator is open for commision
                        </p>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($user->email) }}&su={{ urlencode('Illustration Request') }}&body={{ urlencode('Dear Illustrator, I am interested in your work and would like to discuss a potential illustration project. Please let me know your availability.') }}"
                            target="_blank"
                            class="text-gray-800 font-black bg-yellow-200 px-4 py-2 rounded-lg shadow hover:bg-yellow-300 transition">
                            Request Illustration
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Profile';
    </script>
@endsection

@extends('layouts.main')

@section('body')
    <div class="w-full bg-gray-200 pt-12 pb-8 min-h-screen">
        <!-- Illustration Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mx-auto max-w-[90%] xl:max-w-[70%]">
            <!-- Illustration Image -->
            <div class="flex flex-col md:flex-row">
                <img src="{{ asset($art->image_path) }}"
                    class="w-full md:w-1/2 object-cover rounded-lg shadow-md mb-6 md:mb-0">
                <!-- Details Section -->
                <div class="md:ml-8 flex flex-col justify-between">
                    <!-- Title and Status -->
                    <div class="mb-4">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $art->title }}</h1>
                        <span
                            class="inline-block mt-2 px-3 py-1 text-sm rounded-lg text-white
    {{ $art->is_sold == 0 ? 'bg-green-500' : ($art->is_sold == 1 ? 'bg-yellow-500' : 'bg-red-500') }}">
                            {{ $art->is_sold == 0 ? 'Available' : ($art->is_sold == 1 ? 'Pending' : 'Sold') }}
                        </span>

                    </div>
                    <!-- Description -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-600">Description</h2>
                        <p class="text-gray-700 mt-2">{{ $art->description }}</p>
                    </div>
                    <!-- Pricing -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-600">Price</h2>
                        <p class="text-gray-700 mt-2 font-bold">Rp {{ number_format($art->price, 0, ',', '.') }}</p>
                    </div>
                    <!-- Date Issued -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-600">Date Issued</h2>
                        <p class="text-gray-700 mt-2">{{ $art->date_issued }}</p>
                    </div>
                    <!-- Category -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-600">Category</h2>
                        <p class="text-gray-700 mt-2">{{ $art->category->name }}</p>
                    </div>
                    <!-- Illustrator Name -->
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-600">Illustrator</h2>
                        <a class="text-gray-700 mt-2 font-bold underline text-yellow-500"
                            href="{{ route('showProfile', $art->illustrator->user->id) }}">{{ $art->illustrator->user->name }}</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Action Buttons -->
        @if (Session::has('customer_id') && $art->is_sold == 0)
            <div class="mt-6 flex justify-center gap-4">
                <a href="{{ route('showBuy', $art->id) }}"
                    class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-400 text-black font-bold rounded shadow hover:translate-y-[-5px] hover:scale-105 hover:shadow-lg transition-all duration-300">Buy
                    Now</a>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Illustration Detail'
    </script>
@endsection

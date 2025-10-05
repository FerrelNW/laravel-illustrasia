@extends('layouts.main')

@section('body')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white">
        <div class="container mx-auto px-6 py-16 flex flex-col items-center text-center">
            <h1 class="text-4xl font-bold mb-6">Find the Perfect Illustrations for Your Creative Needs</h1>
            <p class="text-lg max-w-2xl">Whether you’re a business looking for an artwork or an artist showcasing your
                talent, our platform bridges the gap to make creativity accessible for everyone.</p>
            <div class="mt-8">
                <a href="#artworks"
                    class="bg-yellow-400 px-6 py-3 rounded shadow-lg text-black font-bold hover:bg-yellow-300">Explore
                    Artworks</a>
                <a href="#join"
                    class="ml-4 bg-gray-100 px-6 py-3 rounded shadow-lg text-purple-500 font-bold hover:bg-white">Join Now</a>
            </div>
        </div>
    </section>

    <!-- Featured Artworks Section -->
    <section class="py-16 bg-gray-100" id="artworks">
        <div class="mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Featured Artworks</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 justify-center items-center mx-[100px]">
                @foreach ($arts as $item)
                    <div class="flex flex-col align-center items-center text-center min-w-[200px] mx-auto">
                        <img src="{{ $item->image_path }}" class="rounded-lg shadow mb-4 w-[200px] h-[200px] object-cover">
                        <h3 class="font-bold text-xl">{{ $item->title }}</h3>
                        <p class="text-gray-600">{{ $item->illustrator->user->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-gradient-to-r from-yellow-400 to-red-400 text-white" id="join">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Join the Community</h2>
            <p class="max-w-xl mx-auto mb-8">Whether you're an artist eager to showcase your portfolio or a customer
                searching for unique illustrations, Illustrasia is the platform for you.</p>
            <a href="{{ route('index') }}" class="bg-black px-6 py-3 rounded shadow-lg font-bold hover:bg-gray-800">Sign Up Now</a>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.title = 'Homepage';
    </script>
@endsection

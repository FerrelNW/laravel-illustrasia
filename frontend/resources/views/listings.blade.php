@extends('layouts.main')

@section('body')
    <h1 class="text-center font-bold p-4 mt-5 text-4xl mb-3">Listings</h1>
    <div class="grid grid-cols-12 mb-5">
        @foreach ($arts as $item)
            <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                <div
                    class="flex flex-col p-5 m-3 mx-auto bg-gradient-to-br from-slate-500 to-cyan-400 h-[400px] w-[300px] rounded-3xl shadow">
                    <img src="{{ $item->image_path }}" class="rounded-2xl w-full h-[200px] object-cover">
                    <h1 class="mt-1 font-bold text-xl">Rp {{ number_format($item->price, 0, ',', '.') }}</h1>
                    <p class="px-4 py-1 text-sm {{ $item->is_sold == 0 ? 'bg-green-500' : ($item->is_sold == 1 ? 'bg-yellow-500' : 'bg-red-500') }} w-fit italic font-bold rounded-lg mt-1">
                        {{ $item->is_sold == 0 ? 'Available' : ($item->is_sold == 1 ? 'Pending' : 'Sold') }}
                    </p>

                    <h1 class="mt-2 text-white font-bold text-2xl text-center">{{ $item->title }}</h1>
                    <a href="{{ route('showIllustration', $item->id) }}"
                        class="px-4 py-2 w-fit mx-auto mt-auto bg-black text-white inline rounded text-center">Details</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Listings';
    </script>
@endsection

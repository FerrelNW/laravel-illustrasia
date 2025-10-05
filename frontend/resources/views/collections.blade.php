@extends('layouts.main')

@section('body')
    <h1 class="text-center font-bold p-4 mt-5 text-4xl mb-3">Collections</h1>
    <div class="grid grid-cols-12 mb-5">
        @foreach ($arts as $item)
            @if ($item->is_sold != 0)
                <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                    <div
                        class="flex flex-col p-5 m-3 mx-auto bg-gradient-to-br from-blue-500 to-purple-400 h-[400px] w-[300px] rounded-3xl shadow">
                        <img src="{{ $item->image_path }}" class="rounded-2xl w-full h-[200px] object-cover">
                        <p
                            class="px-4 py-1 text-base mt-4 mb-2 {{ $item->is_sold == 0 ? 'bg-green-500' : ($item->is_sold == 1 ? 'bg-yellow-500' : 'bg-green-600') }} w-fit italic font-bold rounded-lg mt-1">
                            {{ $item->is_sold == 0 ? 'Available' : ($item->is_sold == 1 ? 'Pending' : 'Owned') }}
                        </p>
                        <h1 class="mt-1 font-bold text-2xl italic text-white text-center">{{ $item->title }}</h1>
                        <h1 class="text-base italic text-white mt-[-7px] text-center">
                            {{ number_format($item->price, 0, ',', '.') }}</h1>

                        <a href="{{ route('showIllustration', $item->illustration_id) }}"
                            class="px-4 py-2 w-fit mx-auto mt-auto bg-black text-white inline rounded-lg text-center">Details</a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Collections';
    </script>
@endsection

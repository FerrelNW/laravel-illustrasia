@extends('layouts.main')

@section('body')
    <h1 class="text-center font-bold p-4 mt-5 text-4xl mb-3">Illustrations</h1>

    <div class="flex flex-col md:flex-row px-8 mb-3 gap-4 flex-wrap">
        <div class="flex border border-gray-500 rounded-lg w-fit">
            <span class="px-4 my-auto text-center"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" id="title" name="title" class="border border-l-2 w-fit rounded-r-lg p-3"
                placeholder="Illustration title">
        </div>

        <div class="flex border border-gray-500 rounded-lg w-fit ml-0 md:ml-auto">
            <span class="px-4 my-auto text-center"><i class="fa-solid fa-money-bill"></i></span>
            <input type="number" step="1" id="min-price" name="min-price"
                class="border border-l-2 w-fit rounded-r-lg p-3" placeholder="Minimum price">
        </div>

        <div class="flex border border-gray-500 rounded-lg w-fit">
            <span class="px-4 my-auto text-center"><i class="fa-solid fa-money-bill"></i></span>
            <input type="number" step="1" id="max-price" name="max-price"
                class ="border border-l-2 w-fit rounded-r-lg p-3" placeholder="Maximum price">
        </div>

        <select name="category" id="category" class="border border-gray-500 rounded-lg w-fit p-3">
            <option value="" selected>All category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" class="p-3">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-12 mb-5" id="illusContainer">
        @foreach ($illustrations as $item)
            <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
                <div
                    class="flex flex-col p-5 m-3 mx-auto bg-gradient-to-br from-yellow-500 to-red-400 h-[400px] w-[300px] rounded-3xl shadow">
                    <img src="{{ $item->image_path }}" class="rounded-2xl w-full h-[200px] object-cover">
                    <h1 class="mt-1 font-bold text-xl">Rp {{ number_format($item->price, 0, ',', '.') }}</h1>
                    <h1 class="mt-3 text-white font-bold text-2xl text-center">{{ $item->title }}</h1>
                    <p class="mt-0 text-sm italic text-center">by: {{ $item->illustrator->user->name }}</p>
                    <a href="{{ route('showIllustration', $item->id) }}"
                        class="px-4 py-2 w-fit mx-auto mt-auto bg-black text-white inline rounded text-center">Details</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Market';

        $(function() {
            let title = null;
            let minPrice = null;
            let maxPrice = null;
            let category = null;

            $('#title').on('keyup', function() {
                title = $('#title').val();
                filterIllustrations();
            });
            $('#min-price').on('keyup', function() {
                minPrice = $('#min-price').val();
                filterIllustrations();
            });
            $('#max-price').on('keyup', function() {
                maxPrice = $('#max-price').val();
                filterIllustrations();
            });
            $('#category').on('change', function() {
                category = $('#category').val();
                filterIllustrations();
            });


            function filterIllustrations() {
                $.ajax({
                    url: '{{ route('filter') }}',
                    method: 'GET',
                    data: {
                        title: title,
                        minPrice: minPrice,
                        maxPrice: maxPrice,
                        category: category
                    },
                    success: function(response) {
                        // console.log(response)
                        let ele = '';
                        response.forEach(function(illustration) {
                            ele += `
    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3">
        <div class="flex flex-col p-5 m-3 mx-auto bg-gradient-to-br from-yellow-500 to-red-400 h-[400px] w-[300px] rounded-3xl shadow">
            <img src="${illustration.image_path}" class="rounded-2xl w-full h-[200px] object-cover">
            <h1 class="mt-1 font-bold text-xl">Rp ${new Intl.NumberFormat('de-DE').format(illustration.price)}</h1>
            <h1 class="mt-3 text-white font-bold text-2xl text-center">${illustration.title}</h1>
            <p class="mt-0 text-sm italic text-center">by: ${illustration.illustrator_name}</p>
            <a href="/illustration/${illustration.id}" class="px-4 py-2 w-fit mx-auto mt-auto bg-black text-white inline rounded text-center">Details</a>
        </div>
    </div>
    `;
                        });
                        $('#illusContainer').html(ele);
                    },
                    error: function() {
                        alert('Error fetching filtered illustrations');
                    }
                });
            }
        });
    </script>
@endsection

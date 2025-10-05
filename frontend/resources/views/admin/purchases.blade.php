@extends('admin.layouts.main')

@section('body')
    <div class="relative overflow-x-auto sm:rounded-lg p-8 pt-8">
        <h1 class="text-3xl my-3 mb-8 font-bold">Purchase List</h1>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 rounded-lg shadow">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Method
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Payment File
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Buyer
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $index => $item)
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $index + 1 }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->payment_method }}
                        </td>
                        <td class="px-6 py-4 flex">
                            <a href="{{ asset($item->file_path) }}" target="_blank"
                                class="text-black px-4 py-2 mx-auto bg-yellow-500 font-bold rounded w-fit">View File</a>
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->illustration->title }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($item->illustration->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->customer->user->name }}
                        </td>
                        <td class="px-6 py-4 flex justify-center">
                            <form action="{{ route('admin.verify', $item->id) }}" method="POST">
                                @csrf
                                {{-- <input type="number" hidden value="{{ $item->id }}" name="id"> --}}
                                <button
                                    class="bg-green-400 transition-all duration-400 hover:bg-green-500 px-5 py-2 m-1 rounded text-black font-bold">Verify</button>
                            </form>
                            <form action="{{ route('admin.reject', $item->id) }}" method="POST">
                                @csrf
                                {{-- <input type="number" hidden value="{{ $item->id }}" name="id"> --}}
                                <button
                                    class="bg-red-400 transition-all duration-400 hover:bg-red-500 px-5 py-2 m-1 rounded text-black font-bold">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Purchases';
    </script>
@endsection

@extends('admin.layouts.main')

@section('body')
    <div class="relative overflow-x-auto sm:rounded-lg p-8 pt-8">
        <h1 class="text-3xl my-3 mb-8 font-bold">Customer List</h1>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 rounded-lg shadow">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Bio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Arts Bought
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index=>$item)
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $index + 1 }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->user->bio }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->purchase_count }}
                        </td>
                        <td class="px-6 py-4 flex justify-center">
                            <a href="{{ route('admin.showEditCustomer', $item->id) }}" class="bg-yellow-400 transition-all duration-400 hover:bg-yellow-500 px-5 py-2 m-1 rounded text-black font-bold">Edit</a>
                            <a href="{{ route('admin.deleteUser', $item->user->id) }}" class="bg-red-400 transition-all duration-400 hover:bg-red-500 px-5 py-2 m-1 rounded text-black font-bold">Delete</a>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Customers';
    </script>
@endsection

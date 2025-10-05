@extends('admin.layouts.main')

@section('body')
    <div
        class="w-[90%] sm:w-[500px] mx-auto pt-12 h-full px-4 py-4 font-bold text-center text-3xl">
        <h1 class="text-3xl">Edit Customer</h1>

        <form class="mx-auto px-4 w-full mt-3" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.editCustomer', ['id' => $customer->id]) }}">
            @csrf
            <div class="mb-5 w-[100%]">$
                {{-- <input type="number" hidden value="{{ $customer->id }}" name="id"> --}}
                {{-- Name --}}
                <label for="name" class="block mb-1 text-sm font-medium text-gray-900 text-left">Full name</label>
                <input type="text" name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Alexander Great" required value="{{ $customer->user->name }}" />

                {{-- Email --}}
                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 text-left">Email</label>
                <input type="email" name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="name@flowbite.com" required value="{{ $customer->user->email }}" />

                {{-- Bio --}}
                <label for="bio" class="block mb-1 text-sm font-medium text-gray-900 text-left">Bio</label>
                <input type="text" name="bio"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Art enthusiast" required value="{{ $customer->user->bio }}"/>
            </div>

            <a class="text-white bg-red-500 hover:bg-red-700 font-medium rounded text-sm w-full sm:w-auto px-8 py-2.5 text-center" href="{{ route('admin.customers') }}">Cancel</a>
            <button type="submit"
                class="text-white bg-green-500 hover:bg-green-700 font-medium rounded text-sm w-full sm:w-auto px-8 py-2.5 text-center">Save</button>
        </form>
    </div>
@endsection

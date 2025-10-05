@extends('admin.layouts.main')

@section('body')
    <div class="w-[90%] sm:w-[500px] mx-auto pt-12 h-full px-4 py-4 font-bold text-center text-3xl">
        <h1 class="text-3xl">Edit Illustrator</h1>

        <form class="mx-auto px-4 w-full mt-3" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.editIllustrator', ['id' => $illustrator->id]) }}">
            @csrf
            <div class="mb-5 w-[100%]">
                {{-- <input type="number" hidden value="{{ $illustrator->id }}" name="id"> --}}
                {{-- Name --}}
                <label for="name" class="block mb-1 text-sm font-medium text-gray-900 text-left">Full name</label>
                <input type="text" name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Alexander Great" required value="{{ $illustrator->user->name }}" />

                {{-- Email --}}
                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 text-left">Email</label>
                <input type="email" name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="name@flowbite.com" required value="{{ $illustrator->user->email }}" />

                {{-- Bio --}}
                <label for="bio" class="block mb-1 text-sm font-medium text-gray-900 text-left">Bio</label>
                <input type="text" name="bio"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Art enthusiast" required value="{{ $illustrator->user->bio }}" />

                {{-- Experience years --}}
                <label for="experience_years" class="block mb-1 text-sm font-medium text-gray-900 text-left">Years of
                    experience</label>
                <input type="number" name="experience_years"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Art enthusiast" required value="{{ $illustrator->experience_years }}" />

                {{-- Porto --}}
                <label for="portofolio_link"
                    class="block mb-1 text-sm font-medium text-gray-900 text-left">Portofolio</label>
                <input type="text" name="portofolio_link"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Art enthusiast" value="{{ $illustrator->portofolio_link }}" />

                {{-- Open commision --}}
                <label for="is_open_commision" class="block mb-1 text-sm font-medium text-gray-900 text-left">Open
                    Commision</label>
                <select name="is_open_commision"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3">
                    <option value="0" {{ $illustrator->is_open_commision ? '' : 'selected' }}>Close</option>
                    <option value="1" {{ $illustrator->is_open_commision ? 'selected' : '' }}>Open</option>
                </select>
            </div>

            <a class="text-white bg-red-500 hover:bg-red-700 font-medium rounded text-sm w-full sm:w-auto px-8 py-2.5 text-center"
                href="{{ route('admin.illustrators') }}">Cancel</a>
            <button type="submit"
                class="text-white bg-green-500 hover:bg-green-700 font-medium rounded text-sm w-full sm:w-auto px-8 py-2.5 text-center">Save</button>
        </form>
    </div>
@endsection

@extends('auth.base')

@section('body')
    <div
        class="w-[90%] sm:w-[500px] mx-auto h-full bg-white rounded-2xl shadow px-4 py-4 my-12 font-bold text-center text-3xl">
        <h1 class="text-3xl mt-4">Register</h1>
        <h1 class="text-lg text-yellow-500 mb-4">as a customer</h1>
        <h2 class="text-sm text-slate-700 text-left px-4 mt-6">Already has an account? <a href="{{ route('login.customer') }}" class="underline text-yellow-500">Sign in</a></h2>
        <form class="mx-auto px-4 w-full mt-3" method="POST" enctype="multipart/form-data" action="{{ route('register.customer') }}">
            @csrf
            <div class="mb-5 w-[100%]">
                {{-- Name --}}
                <label for="name" class="block mb-1 text-sm font-medium text-gray-900 text-left">Full name</label>
                <input type="text" name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Alexander Great" required value="{{ old('name') }}"/>

                {{-- Email --}}
                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 text-left">Email</label>
                <input type="email" name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="name@flowbite.com" required value="{{ old('email') }}"/>

                {{-- Password --}}
                <label for="password" class="block mb-1 text-sm font-medium text-gray-900 text-left">Password</label>
                <input type="password" name="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="password" required/>

                {{-- Bio --}}
                <label for="bio" class="block mb-1 text-sm font-medium text-gray-900 text-left">Bio</label>
                <input type="text" name="bio"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-3"
                    placeholder="Art enthusiast" required value="{{ old('bio') }}"/>

                {{-- Profile Picture --}}
                <label for="profile_picture" class="block mb-1 text-sm font-medium text-gray-900 text-left">Upload Profile
                    Picture</label>
                <input type="file" name="profile_picture" accept="image/*"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 mb-3"
                    required />
            </div>

            <button type="submit"
                class="text-white bg-black hover:bg-slate-700 font-medium rounded text-sm w-full sm:w-auto px-8 py-2.5 text-center">Submit</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Register Customer'
    </script>
@endsection

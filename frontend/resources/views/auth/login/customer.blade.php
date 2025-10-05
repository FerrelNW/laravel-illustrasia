@extends('auth.base')

@section('body')
    <div
        class="w-[90%] sm:w-[500px] mx-auto h-full bg-white rounded-2xl shadow px-4 py-4 my-12 font-bold text-center text-3xl">
        <h1 class="text-3xl mt-4">Login</h1>
        <h1 class="text-lg text-yellow-500 mb-4">as a customer</h1>
        <h2 class="text-sm text-slate-700 text-left px-4 mt-6">Don't have an account? <a href="{{ route('register.customer') }}" class="underline text-yellow-500">Sign up</a></h2>
        <form class="mx-auto px-4 w-full mt-3" method="POST" enctype="multipart/form-data" action="{{ route('login.customer') }}">
            @csrf
            <div class="mb-5 w-[100%]">
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
            </div>

            <button type="submit"
                class="text-white bg-black hover:bg-slate-700 font-medium rounded text-sm w-full sm:w-auto px-8 py-2.5 text-center">Submit</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Login Customer'
    </script>
@endsection

<nav class="block h-[65px]">
    {{-- Main nav --}}
    <div class="flex justify-center bg-yellow-500 shadow-md h-[65px] fixed top-0 left-0 w-full z-50" id="mainNav">
        {{-- Hamburger --}}
        <div class="hamburger flex items-center justify-center p-2 m-3 border border-black rounded-lg md:hidden cursor-pointer"
            id="hamburger">
            <span><i class="fa-solid fa-bars text-3xl"></i></span>
        </div>
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/logo.PNG') }}" alt="logo" class="h-[65px] hamburger md:hidden">
        </a>

        {{-- Links --}}
        <div class="flex items-center justify-between gap-5 ml-4 hidden md:flex">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/logo.PNG') }}" alt="logo" class="h-[65px]">
            </a>
            <a href="{{ route('home') }}"
                class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 rounded-lg font-bold">Homepage</a>
            <a href="{{ route('market') }}"
                class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 rounded-lg font-bold">Market</a>
            @if (Session::has('customer_id'))
                <a href="{{ route('collections') }}"
                    class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 rounded-lg font-bold">Collections</a>
                <a href="{{ route('histories') }}"
                    class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 rounded-lg font-bold">Histories</a>
            @endif
            @if (Session::has('illustrator_id'))
                <a href="{{ route('listings') }}"
                    class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 rounded-lg font-bold">Listings</a>
                <a href="{{ route('sell') }}"
                    class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 rounded-lg font-bold">Sell
                    Artwork</a>
            @endif
        </div>

        {{-- Profile --}}
        <div class="ml-auto flex items-center mr-3">
            @if (Session::has('user_id'))
                
                <a href="{{ route('showProfile', Session::get('user_id')) }}">
                    <img src="{{ Session::get('profile_picture') ? asset(Session::get('profile_picture')) : asset('assets/pfp.jpg') }}"
                        alt="Profile Picture" class="h-[50px] w-[50px] object-cover bg-white rounded-full">
                </a>
                <a href="{{ route('logout') }}"
                class="px-3 py-2 bg-red-500 text-white hover:bg-red-700 rounded shadow-md text-sm font-bold ml-3">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>

            @else

                {{-- Jika belum login, tampilkan gambar default dan link ke halaman login --}}
                {{-- Anda bisa membuat link di sini jika perlu --}}
                {{-- <a href="{{ route('login.customer') }}"> --}}
                    <img src="{{ asset('assets/pfp.jpg') }}" alt="Default Profile Picture"
                        class="h-[50px] w-[50px] object-cover bg-white rounded-full">
                {{-- </a> --}}

            @endif

        </div>
    </div>

    {{-- Sidebar --}}
    <div class="flex flex-col w-full bg-yellow-500 backdrop-blur items-left justify-between fixed md:hidden top-[65px] left-0 z-10"
        id="sidebar">
        <a href="{{ route('home') }}"
            class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 font-bold">Homepage</a>
        <a href="{{ route('market') }}"
            class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 font-bold">Market</a>
        @if (Session::has('customer_id'))
            <a href="{{ route('collections') }}"
                class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 font-bold">Collections</a>
            <a href="{{ route('histories') }}"
                class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 font-bold">Histories</a>
        @endif
        @if (Session::has('illustrator_id'))
            <a href="{{ route('listings') }}"
                class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 font-bold">Listings</a>
            <a href="{{ route('sell') }}"
                class="px-4 py-2 hover:bg-black hover:text-white transition transition-all duration-400 font-bold">Sell
                Artwork</a>
        @endif
    </div>
</nav>

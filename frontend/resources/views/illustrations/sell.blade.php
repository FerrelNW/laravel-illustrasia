@extends('layouts.main')

@section('body')
    <div class="w-full bg-gray-200 pt-12 pb-8 min-h-screen">
        <!-- Illustration Section -->
        <div class="bg-gradient-to-br from-yellow-500 to-red-500 shadow-lg rounded-lg p-3 mx-auto max-w-[90%] xl:max-w-[70%]">
            <!-- Illustration Image -->
            <div>
                <form action="{{ route('sell') }}" method="POST" enctype="multipart/form-data"
                    class="w-full mx-auto bg-white shadow-md rounded-lg p-6">
                    @csrf <!-- Include CSRF token for security -->

                    <h2 class="text-2xl font-bold text-yellow-500 mb-6">Add Illustration Details</h2>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="Enter illustration title" required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-lg font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="Write a description..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-lg font-medium text-gray-700 mb-2">Price (Rp)</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="Enter price" required>
                        @error('price')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Issued -->
                    <div class="mb-4">
                        <label for="date_issued" class="block text-lg font-medium text-gray-700 mb-2">Date Issued</label>
                        <input type="date" id="date_issued" name="date_issued" value="{{ old('date_issued') }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500"
                            required>
                        @error('date_issued')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-lg font-medium text-gray-700 mb-2">Category</label>
                        <select id="category_id" name="category_id"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500"
                            required>
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select a category
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <img src="" class="w-full md:w-1/2 object-contain rounded-lg shadow-md mb-5" id="image_preview">
                    <div class="mb-4">
                        <label for="image_path" class="block text-lg font-medium text-gray-700 mb-2">Upload Image</label>
                        <input type="file" id="image_path" name="image_path"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500"
                            accept="image/*" required>
                        @error('image_path')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-center">
                        <button type="submit"
                            class="w-fit mx-auto bg-yellow-500 text-black font-bold px-8 py-3 rounded-lg hover:translate-y-[-5px] hover:shadow-2xl hover:shadow-yellow-400 focus:ring-4 focus:ring-yellow-300 transition ease-in-out duration-300">
                            Sell Now
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Sell Artwork';

        // dynamic image change
        document.getElementById('image_path').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image_preview');
                    if (!preview) {
                        const img = document.createElement('img');
                        img.id = 'image_preview';
                        img.src = e.target.result;
                        img.alt = 'Image Preview';
                        img.style.maxWidth = '100%';
                        img.style.marginTop = '1rem';
                        event.target.parentElement.appendChild(img);
                    } else {
                        preview.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection

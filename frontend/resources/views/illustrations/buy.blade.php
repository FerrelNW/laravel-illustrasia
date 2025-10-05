@extends('layouts.main')

@section('body')
    <div class="w-full bg-gray-200 pt-12 pb-8 min-h-screen">
        <!-- Illustration Section -->
        <div
            class="bg-gradient-to-br from-yellow-500 to-red-500 shadow-lg rounded-lg p-3 mx-auto max-w-[90%] xl:max-w-[70%]">
            <!-- Illustration Image -->
            <div>
                <form action="{{ route('buy') }}" method="POST" enctype="multipart/form-data"
                    class="w-full mx-auto bg-white shadow-md rounded-lg p-6">
                    @csrf <!-- Include CSRF token for security -->

                    <h2 class="text-2xl font-bold text-yellow-500 mb-6">Add Payments Details</h2>

                    {{-- Id --}}
                    <input type="number" hidden value="{{ $art->id }}" name="id">

                    {{-- Payment Method --}}
                    <div class="mb-4">
                        <label for="payment_method" class="block text-lg font-medium text-gray-700 mb-2">Payment
                            Method</label>
                        <select name="payment_method" id="payment_method"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500" required>
                            <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>Select payment method</option>
                            <option value="bca">BCA</option>
                            <option value="bri">BRI</option>
                            <option value="ovo">OVO</option>
                        </select>
                    </div>
                    <h1 class="ml-1 italic mt-[-15px]" id="guide"></h1>

                    <!-- Image Upload -->
                    <img src="" class="w-full md:w-1/2 object-contain rounded-lg shadow-md mb-5" id="image_preview">
                    <div class="mb-4">
                        <label for="file_path" class="block text-lg font-medium text-gray-700 mb-2">Upload Image</label>
                        <input type="file" id="file_path" name="file_path"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-yellow-500 focus:border-yellow-500"
                            accept="image/*" required>
                        @error('file_path')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-center">
                        <button type="submit"
                            class="w-fit mx-auto bg-yellow-500 text-black font-bold px-8 py-3 rounded-lg hover:translate-y-[-5px] hover:shadow-2xl hover:shadow-yellow-400 focus:ring-4 focus:ring-yellow-300 transition ease-in-out duration-300">
                            Buy Now
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Buy Artwork';
        $(function(){
            $('#payment_method').on('change', function(){
                $('#guide').html('');
                let val = $(this).val();

                if(val === 'bca'){
                    $('#guide').html('Transfer to BCA account number 1400289132');
                }
                else if(val === 'bri'){
                    $('#guide').html('Transfer to BRI account number 5038492742');
                }
                else if(val === 'ovo'){
                    $('#guide').html('Transfer to OVO account number 083687610142');
                }
            });
        });
    </script>
@endsection

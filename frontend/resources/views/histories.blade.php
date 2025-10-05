@extends('layouts.main')

@section('body')
    <style>
        .history-table ::-webkit-scrollbar {
            width: 6px;
            height: 8px;
            background-color: #FBCD01;
        }

        .history-table ::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #FBCD01, #EC767B);
            border-radius: 10px;
        }
    </style>
    <h1 class="text-center font-bold p-4 mt-5 text-4xl mb-3">Histories</h1>

    <div class="flex flex-col sm:w-[95%] md:w-[80%] mx-auto history-table">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 bg-gradient-to-r from-yellow-400 to-red-400 rounded-lg">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full text-left text-sm font-light text-surface">
                        <thead class="border-b border-neutral-200 font-medium text-center">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Illustration</th>
                                <th scope="col" class="px-6 py-4">Price</th>
                                <th scope="col" class="px-6 py-4">Payment Method</th>
                                <th scope="col" class="px-6 py-4">Proof</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arts as $index => $art)
                                <tr class="border-b border-neutral-200 text-center">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $index + 1 }}</td>
                                    <td class="whitespace-nowrap px-6 py-4"><a
                                            href="{{ route('showIllustration', $art->illustration_id) }}"
                                            class="italic underline">{{ $art->title }}</a></td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ number_format($art->price, 0, '', '.') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $art->payment_method }}</td>
                                    <td class="whitespace-nowrap px-6 py-4"><a href="{{ asset($art->file_path) }}"
                                            target="_blank"
                                            class="px-4 py-2 bg-yellow-500 font-bold rounded-lg shadow-md">View File</a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <p
                                            class="px-4 py-2 font-bold rounded-lg shadow-md {{ $art->is_sold == 0 ? 'bg-red-500' : ($art->is_sold == 1 ? 'bg-yellow-500' : 'bg-green-500') }}">
                                            @if($art->is_sold == 0)
                                                Rejected
                                            @elseif($art->is_sold == 1)
                                                Pending
                                            @else
                                                Bought
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.title = 'Histories';
    </script>
@endsection

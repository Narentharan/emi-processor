<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">EMI Processing</h2>

        <form method="POST" action="{{ route('emi.process') }}">
            @csrf
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                Process Data
            </button>
        </form>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($emiData && count($emiData))
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach(array_keys((array) $emiData[0]) as $col)
                                <th class="py-2 px-4 border-b border-gray-200 font-semibold">{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emiData as $row)
                            <tr class="hover:bg-gray-50">
                                @foreach((array) $row as $key => $cell)
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        @if(is_numeric($cell) && $key !== 'clientid')
                                            {{ number_format($cell, 2) }}
                                        @else
                                            {{ $cell }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $emiData->links() }}
                </div>
            </div>
        @else
            <div class="text-center text-gray-500 mt-8">
                No EMI data available.
            </div>
        @endif
    </div>
</x-app-layout>

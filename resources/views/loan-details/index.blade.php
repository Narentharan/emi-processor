<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Loan Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"> 
                <table class="min-w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="px-4 py-2 border">Client ID</th>
                            <th class="px-4 py-2 border">No. of Payments</th>
                            <th class="px-4 py-2 border">First Payment Date</th>
                            <th class="px-4 py-2 border">Last Payment Date</th>
                            <th class="px-4 py-2 border">Loan Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            <tr class="border-t">
                                <td class="px-4 py-2 border">{{ $loan->clientid }}</td>
                                <td class="px-4 py-2 border">{{ $loan->num_of_payment }}</td>
                                <td class="px-4 py-2 border">{{ $loan->first_payment_date }}</td>
                                <td class="px-4 py-2 border">{{ $loan->last_payment_date }}</td>
                                <td class="px-4 py-2 border">{{ $loan->loan_amount }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    No loan data available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($loans->count())
                    <div class="flex justify-center mt-4">
                        {{ $loans->links() }}
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('emi.index') }}"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        View EMI Processing
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

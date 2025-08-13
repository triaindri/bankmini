<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Saldo Tabungan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">Saldo Tabungan Anda</h3>
                <p class="text-3xl text-green-600 mt-4">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>

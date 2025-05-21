<x-guest-layout>
    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 max-w-md text-justify mx-auto px-1">
        Lupa kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi, sehingga Anda dapat memilih kata sandi baru.
    </p>


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Kirim Tautan') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

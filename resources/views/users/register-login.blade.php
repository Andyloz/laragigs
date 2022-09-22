@php
    use App\Enum\RegLog;
@endphp

<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                {{ $type === RegLog::REGISTER
                    ? 'Register'
                    : 'Login'
                }}
            </h2>
            <p class="mb-4">
                {{ $type === RegLog::REGISTER
                    ? 'Create an account to post gigs'
                    : 'Log into your account'
                }}
            </p>
        </header>

        <form method='post' action="{{ $type === RegLog::REGISTER ? '/users' : '/authenticate' }}">
            @csrf

            @error('form')
            <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
            @enderror

            @if($type === RegLog::REGISTER)
                <div class="mb-6">
                    <label for="name" class="inline-block text-lg mb-2">Name</label>
                    <input
                        type="text" name="name" id="name"
                        class="border border-gray-200 rounded p-2 w-full"
                        value='{{ old('name') }}'
                    />
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">Email</label>
                <input
                    type="email" name="email" id="email"
                    class="border border-gray-200 rounded p-2 w-full"
                    value='{{ old('email') }}'
                />
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block text-lg mb-2">Password</label>
                <input
                    type="password" name="password" id="password"
                    class="border border-gray-200 rounded p-2 w-full"
                />
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if($type === RegLog::REGISTER)
                <div class="mb-6">
                    <label for="password_confirmation" class="inline-block text-lg mb-2">Confirm Password</label>
                    <input
                        type="password" name="password_confirmation" id="password_confirmation"
                        class="border border-gray-200 rounded p-2 w-full"
                    />
                    @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="mb-6">
                <button type="submit" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Sign
                    {{ $type === RegLog::REGISTER ? 'Up' : 'In' }}
                </button>
            </div>

            <div class="mt-8">
                <p>
                    {{ $type === RegLog::REGISTER ? 'Already' : "Don't" }} have an account?
                    <a href="/{{ $type === RegLog::REGISTER ? 'login' : 'register' }}" class="text-laravel">
                        {{ $type === RegLog::REGISTER ? 'Login' : 'Register' }}
                    </a>
                </p>
            </div>
        </form>
    </x-card>
</x-layout>

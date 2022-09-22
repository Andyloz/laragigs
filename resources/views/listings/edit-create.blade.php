@php
    use App\Enum\CrEdit;
@endphp

<x-layout>
    <x-card class="p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                {{ ($type === CrEdit::CREATE ? 'Create' : 'Edit') . ' a Gig' }}
            </h2>
            <p class="mb-4">
                {{ $type === CrEdit::CREATE
                    ? 'Post a gig to find a developer'
                    : "Edit: $listing->title"
                }}
            </p>
        </header>

        <form
            method='post'
            action="/listings{{ $type === CrEdit::CREATE ? '' : "/$listing->id" }}"
            enctype='multipart/form-data'>
            @csrf
            @if($type === CrEdit::EDIT)
                @method('PUT')
            @endif

            <div class="mb-6">
                <label for="company" class="inline-block text-lg mb-2">Company Name</label>
                <input
                    type="text" name="company" id='company'
                    value='{{ $type === CrEdit::CREATE ? old('company') : $listing->company }}'
                    class="border border-gray-200 rounded p-2 w-full"
                />
                @error('company')
                <p class='text-red-500 text-xs mt-1'>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">Job Title</label>
                <input
                    type="text" name="title" id='title'
                    value='{{ $type === CrEdit::CREATE ? old('title') : $listing->title }}'
                    class="border border-gray-200 rounded p-2 w-full"
                    placeholder="Example: Senior Laravel Developer"
                />
                @error('title')
                <p class='text-red-500 text-xs mt-1'>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="location" class="inline-block text-lg mb-2">Job Location</label>
                <input
                    type="text" name="location" id='location'
                    value='{{ $type === CrEdit::CREATE ? old('location') : $listing->location }}'
                    class="border border-gray-200 rounded p-2 w-full"
                    placeholder="Example: Remote, Boston MA, etc"
                />
                @error('location')
                <p class='text-red-500 text-xs mt-1'>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">Contact Email</label>
                <input
                    type="text" name="email" id='email'
                    value='{{ $type === CrEdit::CREATE ? old('email') : $listing->email }}'
                    class="border border-gray-200 rounded p-2 w-full"
                />
                @error('email')
                <p class='text-red-500 text-xs mt-1'>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="website" class="inline-block text-lg mb-2">Website/Application URL</label>
                <input
                    type="text" name="website" id='website'
                    value='{{ $type === CrEdit::CREATE ? old('website') : $listing->website }}'
                    class="border border-gray-200 rounded p-2 w-full"
                />
                @error('website')
                <p class='text-red-500 text-xs mt-1'>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">Tags (Comma Separated)</label>
                <input
                    type="text" name="tags" id='tags'
                    value='{{ $type === CrEdit::CREATE ? old('tags') : $listing->tags }}'
                    class="border border-gray-200 rounded p-2 w-full"
                    placeholder="Example: Laravel, Backend, Postgres, etc"
                />
                @error('tags')
                <p class='text-red-500 text-xs mt-1'>{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="logo" class="inline-block text-lg mb-2">Company Logo</label>
                <input
                    type="file" name="logo" id='logo'
                    class="border border-gray-200 rounded p-2 w-full"
                />
                @error('logo')
                <p class='text-red-500 text-xs mt-1'>{{ $message }}</p>
                @enderror
                @if($type === CrEdit::EDIT)
                    <img
                        class="w-48 mr-6 mb-6"
                        src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('images/no-image.png') }}"
                        alt=""
                    />
                @endif
            </div>

            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">Job Description</label>
                <textarea
                    rows="10" name="description" id='description'
                    class="border border-gray-200 rounded p-2 w-full"
                    placeholder="Include tasks, requirements, salary, etc"
                >{{ $type === CrEdit::CREATE ? old('description') : $listing->description }}</textarea>
            </div>

            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    {{ $type === CrEdit::CREATE ? 'Create' : 'Edit' . ' gig' }}
                </button>
                <a href="/{{ $type === CrEdit::CREATE ? '' : "listings/$listing->id" }}" class="text-black ml-4">Back</a>
            </div>
        </form>
    </x-card>
</x-layout>

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title" class="text-redb">{{ $title }}</x-slot>
        <x-slot name="description" class="text-redb">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-greenbg shadow sm:rounded-lg">
            {{ $content }}
        </div>
    </div>
</div>

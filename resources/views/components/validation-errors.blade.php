@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-sm text-red-600 text-center">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="mt-2 list-disc list-inside text-xs text-red-600 text-center">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

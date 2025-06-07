@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-creamcard rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] text-blackAuth text-xs placeholder:text-greyAuth placeholder:text-xs']) !!}>

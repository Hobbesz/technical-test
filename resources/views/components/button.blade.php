<a
    class="rounded-md bg-blue-700 text-white px-4 py-2 hover:bg-blue-800 cursor-pointer"
    @isset($href) href="{{ $href }}" @endisset
    @isset($onclick) onclick="{{ $onclick }}" @endisset
>{{ $label }}</a>
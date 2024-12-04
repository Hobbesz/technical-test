<nav class="bg-gray-900">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center sm:items-stretch justify-start">
                <div class="flex shrink-0 items-center text-white pl-2 sm:pl-0">
                    {{ config('app.name', 'Laravel') }}
                </div>
            </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0 gap-2">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    @include('components.button', ['href' => route('login'), 'label' => 'Login'])
                @endif

                @if (Route::has('register'))
                    @include('components.button', ['href' => route('register'), 'label' => 'Register'])
                @endif
            @else
                <span class="text-white hidden sm:flex">
                    {{ Auth::user()->name }}
                </span>

                @include('components.button', ['href' => route('logout'), 'onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();", 'label' => 'Logout'])

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endguest
        </div>
    </div>
</nav>

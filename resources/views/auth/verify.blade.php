@extends('layouts.app')

@section('content')
    <card>
        <template v-slot:header>Verify Your Email Address</template>

        <template v-slot:content>
            @if (session('resent'))
                <div class="rounded-md bg-red-100 text-red-800 px-4 py-2 mb-4">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form id="request-verification-form" class="inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                
                <a onclick="document.getElementById('request-verification-form').submit();" class="underline text-blue-400">{{ __('click here to request another') }}</a>.
            </form>
        </template>
    </card>
@endsection

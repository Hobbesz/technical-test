@extends('layouts.app')

@section('content')
    <card>
        <template v-slot:header>Register</template>
        <template v-slot:content>
            <form id="register-form" method="POST" action="{{ route('register') }}" class="grid grid-cols-12 gap-3">
                @csrf

                @include('components.input', ['id' => 'name', 'label' => 'Name', 'name' => 'name', 'required' => true, 'autofocus' => true])

                @include('components.input', ['id' => 'email', 'label' => 'Email Address', 'name' => 'email', 'type' => 'email', 'required' => true])

                @include('components.input', ['id' => 'password', 'label' => 'Password', 'name' => 'password', 'type' => 'password', 'required' => true])

                @include('components.input', ['id' => 'password-confirm', 'label' => 'Password Confirmation', 'name' => 'password_confirmation', 'type' => 'password', 'required' => true])

                <div class="col-span-8 flex">
                    @include('components.button', ['onclick' => "document.getElementById('register-form').submit();", 'label' => 'Register'])
                </div>
            </form>
    </template>
@endsection

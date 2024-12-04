<template>
    <card>
        <template v-slot:header>Login</template>
        <template v-slot:content>
            <div class="grid grid-cols-12 gap-3">

                <vue-input id="email" label="Email Address" name="email" type="email" :required="true" :autofocus="true" v-model="email" />
                <vue-input id="password" label="Password" name="password" type="password" :required="true" v-model="password" />

                <div class="col-span-6">
                    <input type="checkbox" name="remember" id="remember">

                    <label for="remember">
                        Remember Me
                    </label>
                </div>

                <div class="col-span-8 flex gap-4">
                    <vue-button @click="login()" label="Login" />

                    
                    <a class="underline text-blue-400" href="/password/request'">
                        Forgot Your Password?
                    </a>
                </div>
            </div>
        </template>
    </card>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');

const router = useRouter();

axios.defaults.withCredentials = true;

axios.get('/sanctum/csrf-cookie');

const login = () => {
    axios.post(
        '/login',
        {
            'email': email.value,
            'password': password.value,
        }
    ).then((response) => {
        // let token = response.data.token;
        // axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        router.push({ name: 'home' });
    });
};
</script>

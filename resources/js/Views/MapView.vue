<template>
    <card>
        <template v-slot:header>Wind Farm: {{ windFarm?.name }}</template>
        <template v-slot:content>
            <loading-spinner v-if="loading" />
            <div v-else-if="error">{{ error }}</div>
            <map-wind-farm v-else :wind-farm="windFarm" />
        </template>
    </card>
</template>

<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const windFarm = ref(undefined);
const loading = ref(true);
const error = ref('');
const selectedTurbine = ref(undefined);

axios.get('/api/wind-farms/' + route.params.id)
    .then((response) => {
        windFarm.value = response.data.data;
    })
    .catch((response) => {
        if (response.status == 404) {
            error.value = 'Wind farm not found';
        } else if (response.status == 401) {
            error.value = 'Unauthorized';
            router.push({name: 'login'});
        } else {
            error.value = 'Something went wrong, try again';
        }
    })
    .finally(() => {
        loading.value = false;
    });
</script>

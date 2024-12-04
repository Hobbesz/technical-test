<template>
    <card>
        <template v-slot:header>Home</template>
        <template v-slot:content>
            <loading-spinner v-if="loading" />
            <ul v-else-if="windFarms.length > 0" role="list" class="divide-y divide-gray-100">
                <list-item v-for="windFarm in windFarms" :wind-farm="windFarm" @deleted="updateWindFarms" />
            </ul>
            <div v-else-if="error">
                {{ error }}
            </div> 
            <div v-else>
                No Wind Farms
            </div> 
        </template>
    </card>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const windFarms = ref([]);
const loading = ref(true);
const error = ref('');

const updateWindFarms = () => {
    loading.value = true;
    axios.get('/api/wind-farms')
        .then((response) => {
            windFarms.value = response.data.data;
        })
        .catch((response) => {
            if (response.status == 401) {
                router.push({name: 'login'});
            }
            error.value = 'Something went wrong, try again';
        })
        .finally(() => {
            loading.value = false;
        });
};

updateWindFarms();
</script>

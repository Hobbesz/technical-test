<template>
    <div class="flex flex-col gap-4">
        <span class="font-medium text-lg">Turbine: {{ turbine.name }}</span>

        <loading-spinner v-if="loading" />
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2 my-4">
            <part-item v-for="part in parts" :part="part" :turbine="turbine" :key="part.id" @update="updateParts" />
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref } from 'vue';

const { turbine } = defineProps({
    turbine: {
        type: Object,
        required: true,
    },
});

const parts = ref([]);
const loading = ref(true);

const updateParts = () => {
    loading.value = true;
    parts.value = [];
    axios.get(`/api/wind-farms/${turbine.wind_farm_id}/turbines/${turbine.id}/parts`)
        .then((response) => {
            parts.value = response.data.data;
            loading.value = false;
        });
};

updateParts();
</script>

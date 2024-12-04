<template>
    <google-map
        :api-key="apiKey"
        style="width: 100%; height: 500px"
        map-id="DEMO_MAP_ID"
        :center="center"
        :zoom="12"
    >
        <advanced-marker v-for="turbine in turbines" :options="{ position: getTurbineLatLng(turbine) }" @click="selectedTurbine = turbine" />
    </google-map>
</template>

<script setup>
import { defineEmits, defineProps, ref } from 'vue';
import { GoogleMap, AdvancedMarker } from 'vue3-google-map';

defineEmits(['open-turbine']);

const { windFarm } = defineProps({
    windFarm: {
        type: Object,
        required: true,
    },
});

const turbines = ref([]);
const selectedTurbine = ref(undefined);
const center = { lat: windFarm.latitude, lng: windFarm.longitude };
const apiKey = process.env.MIX_GOOGLE_MAPS_API_KEY;

axios.get('/api/wind-farms/' + windFarm.id + '/turbines')
    .then((response) => {
        turbines.value = response.data.data;
    });

const getTurbineLatLng = (turbine) => {
    return {
        lat: windFarm.latitude + turbine.x_position_offset,
        lng: windFarm.longitude + turbine.y_position_offset,
    };
};
</script>

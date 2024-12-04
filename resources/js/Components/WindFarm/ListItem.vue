<template>
    <li class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
        <div class="min-w-0 flex-auto">
            <p class="text-sm/6 font-semibold text-gray-900">{{ windFarm.name }}</p>
            <p class="mt-1 truncate text-xs/5 text-gray-500">Coordinates: {{ windFarm.latitude }}, {{ windFarm.longitude }}</p>
        </div>
        </div>
        <div class="shrink-0 flex sm:items-end gap-2">
            <vue-button label="View Wind Farm" icon="Eye" @click="router.push({ name: 'wind-farm', params: { id: windFarm.id } })" />
            <vue-button negative label="Delete" icon="Trash" @click="destroy" />
        </div>
    </li>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const props = defineProps({
    windFarm: Object
});

const emit = defineEmits(['deleted']);

const destroy = () => {
    axios.delete('/api/wind-farms/' + props.windFarm.id).then(() => {
        emit('deleted');
    });
};
</script>

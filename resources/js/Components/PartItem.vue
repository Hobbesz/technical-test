<template>
    <div class="rounded-md flex gap-4 flex flex-grow justify-between p-4 bg-gray-100">
        <div class="flex flex-col">
            <span class="font-medium">{{ part.name }}</span>
            <span>Condition rating: {{ part.condition_rating }}</span>
        </div>
        <vue-button label="Update condition" @click="showModal = true" />
        <part-modal
            v-if="showModal"
            :part="part"
            :turbine="turbine"
            @close="showModal = false"
            @update="updatePart"
        />
    </div>
</template>

<script setup>
import { defineEmits, defineProps, ref } from 'vue';

const emit = defineEmits(['update']);

defineProps({
    part: {
        required: true,
        type: Object,
    },
    turbine: {
        required: true,
        type: Object,
    },
});

const showModal = ref(false);

const updatePart = () => {
    showModal.value = false;
    emit('update');
};
</script>

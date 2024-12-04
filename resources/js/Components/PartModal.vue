<template>
    <div id="default-modal" tabindex="-1" class="bg-gray-500/[0.4] overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full m-auto">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold">
                    Update {{ part.name }}
                </h3>
            </div>

            <div class="px-4 py-8 gap-4 flex items-center">
                <label for="condition_rating" class="flex-shrink-0">Condition rating</label>
                <select
                    id="condition_rating"
                    name="condition_rating"
                    :value="conditionRating"
                    @change="conditionRating = $event.target.value"
                    @input="conditionRating = $event.target.value"
                    class="shadow appearance-none border border-gray-200 w-full rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-400"
                >
                    <option v-for="option in options" :key="option" :value="option">{{ option }}</option>
                </select>
            </div>

            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b gap-4">
                <vue-button label="Update" @click="updatePart" />
                <vue-button label="Cancel" negative @click="emit('close')" />
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { defineEmits, defineProps, ref } from 'vue';

const emit = defineEmits(['close', 'update']);

const { part, turbine } = defineProps({
    part: {
        required: true,
        type: Object,
    },
    turbine: {
        required: true,
        type: Object,
    },
});

const conditionRating = ref(part.condition_rating);
const options = [1, 2, 3, 4, 5];

const updatePart = () => {
    axios.patch(
        `/api/wind-farms/${turbine.wind_farm_id}/turbines/${turbine.id}/parts/${part.id}`,
        {
            'condition_rating': conditionRating.value,
        },
    ).then((response) => {
        emit('update');
    });
};
</script>

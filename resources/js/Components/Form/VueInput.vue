<template>
    <label for="{{ id }}" class="col-span-4">{{ label }}</label>

    <div class="col-span-6">
        <input
            :id="id"
            :type="type"
            class="shadow appearance-none border border-gray-200 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-400"
            :name="name"
            :required="required"
            :autocomplete="autocomplete"
            :autofocus="autofocus"
            :value="modelValue"
            @input="update"
            @change="update"
        >

        <span class="text-red-600" v-if="$slots.error">
            <strong><slot name="error"></slot></strong>
        </span>
    </div>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';

defineProps({
    id: {
        required: true,
        type: String,
    },
    modelValue: {
        required: true,
        type: String,
    },
    label: {
        required: true,
        type: String,
    },
    type: {
        type: String,
        default: 'text',
    },
    name: {
        required: true,
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
    autofocus: {
        type: Boolean,
        default: false,
    },
    autocomplete: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

const update = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

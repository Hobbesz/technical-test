<template>
    <a
        class="rounded-md text-white px-4 py-2 cursor-pointer flex gap-2 items-center"
        :class="negative ? 'bg-red-700 hover:bg-red-800' : 'bg-blue-700 hover:bg-blue-800'"
        :href="href"
    >
        <component v-if="HeroIcon !== undefined" :is="HeroIcon" class="text-white h-5 w-5 sm:h-4 sm:w-4" />
        <span :class="HeroIcon !== undefined ? 'hidden sm:block' : ''">{{ label }}</span>
    </a>
</template>

<script setup>
import { defineProps, ref, watch } from 'vue';
import * as HeroIcons from '@heroicons/vue/24/outline';

const props = defineProps({
    href: {
        type: String
    },
    label: {
        type: String,
        required: true,
    },
    negative: {
        type: Boolean,
        default: false,
    },
    icon: {
        type: String,
    },
});

const {...icons} = HeroIcons;
const HeroIcon = ref(undefined);

const setHeroIcon = (icon) => {
    icon += 'Icon';
    if (icons[icon]) {
        HeroIcon.value = icons[icon];
    } else {
        HeroIcon.value = undefined;
    }
}

setHeroIcon(props.icon);

watch(() => props.icon, (icon) => {
    setHeroIcon(icon);
});
</script>

<script setup>
import {useAttrs} from 'vue';

defineProps({
    marginClass: {
        type: String,
        default: ""
    },
    widthClass: {
        type: String,
        default: "w-full"
    }
});

const attrs = useAttrs();
</script>

<template>
    <button
        v-bind="attrs"
        :class="[widthClass, 'px-6 py-3 text-white font-bold rounded-2xl cursor-pointer transition bg-jaffa-500  hover:bg-jaffa-400 focus:ring-2 focus:outline-none focus:ring-jaffa-600 disabled:bg-stone-700 disabled:cursor-not-allowed', marginClass]">
        <slot/>
    </button>
</template>

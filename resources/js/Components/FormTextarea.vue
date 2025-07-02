<script setup>
import { useAttrs } from 'vue'

const model = defineModel()

defineProps({
    paddingClass: {
        type: String,
        default: "p-2 ps-5"
    },
});

const attrs = useAttrs();
</script>

<template>
    <textarea
        v-bind="attrs"
        v-model="model"
        :class="['block w-full rounded-2xl border focus:outline-none bg-stone-700 border-stone-700 placeholder-stone-400 text-white focus:ring-jaffa-500 focus:border-jaffa-500', paddingClass]"/>
</template>

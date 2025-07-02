<script setup>
import {useAttrs} from 'vue'

const model = defineModel();

defineProps({
    errors: Object,
    paddingClass: {
        type: String,
        default: "p-2 ps-5"
    },
});

const attrs = useAttrs();
const inputName = attrs.name;

</script>

<template>
    <input
        v-bind="attrs"
        v-model="model"
        :class="['block w-full rounded-2xl border focus:outline-none bg-stone-700 border-stone-700 placeholder-stone-400 text-white focus:ring-jaffa-500 focus:border-jaffa-500 disabled:bg-jaffa-400/30 disabled:text-stone-400 disabled:cursor-not-allowed', paddingClass]">
    <div
        v-if="errors?.[inputName]"
        class="text-sm text-jaffa-500 mt-1">
        {{ errors[inputName] }}
    </div>

</template>

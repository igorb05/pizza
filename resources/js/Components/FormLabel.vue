<script setup>
import { useAttrs } from 'vue'
const attrs = useAttrs();
</script>

<template>
    <label
        v-bind="attrs"
        class="text-sm inline-block mb-1 font-bold sm:text-base">
        <slot/>
    </label>
</template>

<script setup>
import { useAttrs } from 'vue'
const attrs = useAttrs();
</script>

<template>
    <label
        v-bind="attrs"
        class="inline-block mb-1 font-bold">
        <slot/>
    </label>
</template>

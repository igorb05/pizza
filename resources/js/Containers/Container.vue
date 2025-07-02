<script setup>
import {useAttrs} from "vue";

const attrs = useAttrs();
</script>

<template>
    <div v-bind="attrs" class="container max-w-screen-xl mx-auto px-3">
        <slot/>
    </div>
</template>

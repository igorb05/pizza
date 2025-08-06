<script setup>
defineProps({
    widthClass: {
        type: String,
        default: "w-full"
    },
});
</script>

<template>
    <div :class="[widthClass, 'bg-stone-700/30 rounded-3xl px-5 py-6 sm:px-9 sm:py-8']">
        <slot/>
    </div>
</template>

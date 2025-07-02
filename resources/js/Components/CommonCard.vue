<script setup>
defineProps({
    widthClass: {
        type: String,
        default: "w-full"
    },
});
</script>

<template>
    <div :class="[widthClass, 'bg-stone-700/30 rounded-3xl px-9 py-8']">
        <slot/>
    </div>
</template>

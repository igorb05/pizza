<script setup>
const props = defineProps({
    image: String,
    title: String,
    description: String,
});
</script>

<template>
    <div class="flex flex-col items-center gap-y-1 m-auto my-5 text-center max-w-3xs">
        <img :src="props.image" :alt="props.title" class="pointer-events-none select-none w-[120px] h-[120px]">
        <div class="text-2xl text-white text-pretty">{{ props.title }}</div>
        <div class="text-stone-400">{{ props.description }}</div>
    </div>
</template>

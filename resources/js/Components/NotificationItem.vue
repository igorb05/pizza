<script setup>
import {onMounted, ref, onUnmounted} from 'vue';

const props = defineProps({
    notification: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close']);

const timer = ref(null);
const progress = ref(100);

const DURATION = 5000;
const INTERVAL = 50;
const STEP = (INTERVAL / DURATION) * 100;

const close = () => {
    if (timer.value) {
        clearInterval(timer.value);
        timer.value = null;
    }
    emit('close', props.notification.id);
};

onMounted(() => {
    timer.value = setInterval(() => {
        progress.value -= STEP;
        if (progress.value <= 0) {
            close();
        }
    }, INTERVAL);
});

onUnmounted(() => {
    if (timer.value) {
        clearInterval(timer.value);
    }
});
</script>

<template>
    <div class="relative overflow-hidden bg-jaffa-400/30 backdrop-blur-md rounded-2xl py-5 px-8 min-w-[320px]">
        <div
            class="absolute bottom-0 left-0 h-1 bg-jaffa-500 transition-all duration-75 ease-linear"
            :style="{ width: `${progress}%` }"
        />
        <div class="flex items-center gap-3">
            <div class="text-white text-pretty leading-5">
                {{ notification.message }}
            </div>
            <button
                @click="close"
                type="button"
                class="absolute top-2.5 right-5 text-2xl font-bold text-white hover:text-jaffa-500 cursor-pointer transition hover:scale-150"
            >
                ×
            </button>
        </div>
    </div>
</template>

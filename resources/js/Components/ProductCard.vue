<script setup>
import {useModalStore} from '@/Stores/modal.js';

const modalStore = useModalStore();

const props = defineProps({
    pizzaId: Number,
    name: String,
    description: String,
    image: String,
    price: Number,
    config: Object
});

const pizza = props;

const handleAddClick = () => {
    modalStore.openProductDetails(props);
};
</script>

<template>
    <div class="flex flex-col justify-between w-full sm:w-2xs">
        <div>
            <div class="bg-jaffa-400/30 rounded-2xl">
                <img :src="pizza.image" alt="" class="mx-auto">
            </div>
            <div class="text-2xl dark:text-white mt-3.5">{{ pizza.name }}</div>
            <div class="text-sm text-stone-400 mt-1.5">{{ pizza.description }}</div>
        </div>
        <div class="flex flex-col justify-between">
            <div class="flex justify-between mt-3">
                <div class="text-xl dark:text-white">от <b>{{ pizza.price }}</b> ₽</div>
                <button
                    @click="handleAddClick"
                    class="bg-jaffa-400/30 rounded-2xl text-jaffa-400 px-3.5 py-1.5 cursor-pointer hover:bg-jaffa-400/50 ease-in delay-100"
                    type="button">
                    Добавить
                </button>
            </div>
        </div>
    </div>
</template>

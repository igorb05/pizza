<script setup>
import {ref, watch} from 'vue';
import {debounce} from 'lodash';
import { useModalStore } from '@/Stores/modal.js';

const searchQuery = ref('');
const results = ref([]);
const loading = ref(false);

const fetchResults = debounce(async () => {
    const query = searchQuery.value.trim();

    if (query.length < 3) {
        results.value = [];
        loading.value = false;
        return;
    }

    loading.value = true;

    try {
        const response = await fetch('/search?' + new URLSearchParams({
            query: query
        }), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
        const data = await response.json();
        results.value = data.results || data;
    } catch (e) {
        console.error('Ошибка поиска:', e);
    } finally {
        loading.value = false;
    }
}, 400);

const modalStore = useModalStore();
const handleProductClick = (product) => {

    setTimeout(() => {
        modalStore.openProductDetails(product);

    }, 100);

    results.value = [];
    searchQuery.value = ''
};

watch(searchQuery, fetchResults);
</script>

<template>
    <div class="relative hidden md:block">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <img src="/images/icons/search.svg" alt="Search Icon" class="w-4 h-4">
        </div>
        <input type="text"
               v-model="searchQuery"
               id="search-navbar"
               class="block w-full p-2 ps-10 rounded-2xl border focus:outline-none bg-stone-700 border-stone-700 placeholder-stone-400 text-white focus:ring-jaffa-500 focus:border-jaffa-500"
               placeholder="Найти...">
        <ul v-if="results.length" v-auto-animate
            class="absolute text-white bg-stone-700 border border-stone-700 w-full mt-1 rounded-2xl z-10">
            <li v-if="loading" class="transition text-jaffa-400 gap-x-3.5 p-2">
                Поиск...
            </li>
            <li v-else
                v-for="pizza in results"
                :key="pizza.id"
                @click="handleProductClick(pizza)"
                class="flex items-center gap-x-3.5 p-2 transition hover:cursor-pointer hover:text-jaffa-400">
                <img :src="pizza.image" class="size-8" :alt="pizza.name">
                {{ pizza.name }} –
                {{ pizza.price }} ₽
            </li>
        </ul>
    </div>
</template>

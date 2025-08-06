<script setup>
import {onMounted, ref, watch} from 'vue';
import CommonButton from '@/Components/CommonButton.vue';

const props = defineProps({
    sortBy: String,
});

const emit = defineEmits(['pizzas-loaded']);

const pizzas = ref([]);
const asc = ref("");
const desc = ref("");
const selectedIngredients = ref([]);

const fetchPizzas = async () => {
    try {
        const response = await fetch('/pizzas?' + new URLSearchParams({
            sort: props.sortBy,
            asc: asc.value ?? null,
            desc: desc.value ?? null,
            ingredients: selectedIngredients.value ?? null
        }), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
        const data = await response.json();
        pizzas.value = data || data;
        emit('pizzas-loaded', data);
    } catch (e) {
        console.error('Ошибка загрузки данных:', e);
    }
};

onMounted(fetchPizzas);
watch(() => props.sortBy, fetchPizzas);
</script>

<template>
    <div class="flex flex-col min-w-3xs">
        <div class="flex items-center gap-x-4 text-2xl text-white">Фильтрация</div>
        <div class="text-white text-lg mt-5">Цена от и до</div>
        <div class="flex gap-x-1.5 mt-2.5">
            <input v-model="asc" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="4"
                   class="block w-24 p-2 ps-4 rounded-2xl border focus:outline-none  bg-stone-700 border-stone-700 placeholder-stone-400 text-white focus:ring-jaffa-500 focus:border-jaffa-500">
            <input v-model="desc" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="4"
                   class="block w-24 p-2 ps-4 rounded-2xl border focus:outline-none bg-stone-700 border-stone-700 placeholder-stone-400 text-white focus:ring-jaffa-500 focus:border-jaffa-500">
        </div>
        <div class="text-white text-lg mt-5 border-t-stone-400">Ингредиенты</div>
        <div v-for="ingredient in ['Цыпленок', 'Пепперони', 'Ветчина', 'Пармезан', 'Моцарелла', 'Томаты', 'Ананас']"
             :key="ingredient" class="flex items-center mt-2.5">
            <input
                type="checkbox"
                :value="ingredient"
                v-model="selectedIngredients"
                class="w-5 h-5 appearance-none cursor-pointer checked:bg-no-repeat checked:bg-center checked:border-jaffa-500 checked:bg-jaffa-500  rounded-sm focus:outline-none focus:ring-jaffa-600 ring-offset-jaffa-800 bg-stone-700 border-stone-600"
            />
            <label class="ms-2 text-white">{{ ingredient }}</label>
        </div>
    </div>
    <CommonButton
        @click="fetchPizzas"
        margin-class="mt-10"
    >
        Применить
    </CommonButton>
</template>

<style scoped>
input[type="checkbox"]:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
}
</style>

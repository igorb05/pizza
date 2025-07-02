<script setup>
const sortBy = defineModel('sortBy', { default: 'default' })
</script>

<template>
    <h1 class="text-4xl text-white mt-8 mb-4">Все пиццы</h1>
    <div class="flex gap-x-1 text-white rounded-2xl w-fit px-6 py-3.5 bg-stone-700">
        <div>Сортировка:</div>
        <select v-model="sortBy" class="text-jaffa-400 focus:ring-2 focus:outline-none focus:ring-jaffa-900">
            <option value="default">по умолчанию</option>
            <option value="desc">сначала дороже</option>
            <option value="asc">сначала дешевле</option>
        </select>
    </div>
</template>

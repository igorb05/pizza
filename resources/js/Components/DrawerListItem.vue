<script setup>
const props = defineProps({
    pizza: Object,
    index: Number
});

const pizza = props.pizza;
const calculatePrice = () => {
    return props.pizza.price * props.pizza.quantity;
};

const emit = defineEmits(['increment', 'decrement']);
</script>

<template>
    <div class="bg-stone-700 rounded-3xl p-4 not-first:my-4">
        <div class="flex items-center gap-x-5">
            <img :src="pizza.image" class="w-1/4" alt="Pizza">
            <div class="text-white w-full">
                <div class="py-3 border-b border-neutral-800/50">
                    <div class="text-xl font-bold">{{ pizza.name }}</div>
                    <div v-if="pizza.addons.length >= 1">Добавки: {{ pizza.addons.join(', ').toLowerCase() }}</div>
                    <div class="text-stone-400 text-sm">{{ pizza.size.toLowerCase() }}, {{
                            pizza.crust.toLowerCase()
                        }}
                    </div>
                </div>
                <div class="flex justify-between py-3 items-center">
                    <div class="flex items-center gap-x-2 font-bold">
                        <div @click="emit('decrement', index)"
                             class="select-none border border-jaffa-500 hover:bg-jaffa-500 transition rounded-lg cursor-pointer text-xl px-2">
                            −
                        </div>
                        <div>{{ pizza.quantity }}</div>
                        <div @click="emit('increment', index)"
                             :class="['select-none border border-jaffa-500 hover:bg-jaffa-500 transition rounded-lg cursor-pointer text-xl px-2', pizza.quantity >= 5 ? 'bg-jaffa-500' : '']">
                            +
                        </div>
                    </div>
                    <div class="text-lg font-bold">{{ calculatePrice() }} ₽</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed} from 'vue'
import {router} from '@inertiajs/vue3';
import {useCartStore} from '@/Stores/cart.js';
import {useClickOutside} from '@/Composables/useClickOutside.js';
import DrawerList from '@/Components/DrawerList.vue'
import DrawerListItem from '@/Components/DrawerListItem.vue'
import CommonButton from '@/Components/CommonButton.vue';
import StatusBlock from '@/Components/StatusBlock.vue';

const drawerRef = ref(null);
const cartStore = useCartStore();
const cart = cartStore.items;

const increment = (index) => {
    cartStore.incrementQuantity(index)
};

const decrement = (index) => {
    cartStore.decrementQuantity(index)
};

const orderCreate = () => {
    cartStore.closeDrawer();
    setTimeout(() => {
        router.visit('/order/create');
    }, 100);
};

const totalPrice = computed(() => cartStore.totalPrice);

useClickOutside(drawerRef, cartStore.closeDrawer, true);
</script>

<template>
    <div class="fixed top-0 left-0 w-full h-full bg-stone-700/70 z-30">
        <div ref="drawerRef" class="fixed overflow-y-scroll w-full bg-neutral-800 h-full top-0 right-0 z-20 p-5 sm:w-128 sm:p-10">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-white">Корзина</h2>
                <div @click="cartStore.closeDrawer"
                     class="text-3xl font-bold text-white cursor-pointer transition hover:text-jaffa-400 hover:scale-150 sm:text-2xl">
                    ×
                </div>
            </div>
            <DrawerList>
                <DrawerListItem
                    v-for="(pizza, index) in cart"
                    :key="index"
                    :pizza="pizza"
                    :index="index"
                    @increment="increment"
                    @decrement="decrement"
                />
            </DrawerList>
            <div v-if="cart.length >= 1" class="flex flex-col gap-y-5">
                <div class="flex justify-between text-2xl text-white border-b border-dashed border-stone-700 py-2">
                    <span>Итого:</span>
                    <b>{{ totalPrice }} ₽</b>
                </div>
                <CommonButton
                    :disabled="false"
                    @click="orderCreate">
                    Оформить
                </CommonButton>
            </div>
            <div v-else class="flex flex-col h-full justify-center">
                <StatusBlock
                    image="/images/icons/empty-cart.png"
                    title="Корзина пуста"
                    description="Добавьте хотя бы одну пиццу, чтобы совершить заказ"
                />
            </div>
        </div>
    </div>
</template>

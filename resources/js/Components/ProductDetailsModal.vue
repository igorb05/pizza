<script setup>
import {ref} from 'vue';
import {useCartStore} from '@/Stores/cart.js';
import {useModalStore} from '@/Stores/modal.js';
import {useClickOutside} from '@/Composables/useClickOutside.js';
import {useProductConfigurator} from '@/Composables/useProductConfigurator.js';
import CommonButton from '@/Components/CommonButton.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const pizza = props.product;

const cartStore = useCartStore();
const modalStore = useModalStore();

const {
    sizes,
    crusts,
    addons,
    selectedSize,
    selectedCrust,
    selectedAddons,
    sizeDescription,
    calculatedPrice,
    selectSize,
    selectCrust,
    toggleAddon,
    getCartConfiguration
} = useProductConfigurator(pizza);

const addToCart = () => {
    const cartItem = getCartConfiguration();
    cartStore.addToCart(cartItem);
    modalStore.closeProductDetails();
};

const modalRef = ref(null);
useClickOutside(modalRef, modalStore.closeProductDetails, true);
</script>

<template>
    <div
        class="fixed inset-0 bg-stone-700/70 z-10 flex justify-center items-center">
        <div ref="modalRef" class="relative overflow-y-scroll w-full max-w-3xl bg-neutral-800 sm:rounded-2xl sm:overflow-y-visible">
            <button @click="modalStore.closeProductDetails"
                    class="absolute top-2.5 right-5 z-10 text-3xl font-bold text-white cursor-pointer transition hover:text-jaffa-400 hover:scale-150 sm:-right-8 sm:top-0">
                x
            </button>

            <div class="flex flex-col h-screen gap-x-4 sm:flex-row sm:h-max">
                <div class="flex items-center relative min-w-xs bg-stone-700 p-8 sm:rounded-l-2xl">
                    <img :src="pizza.image"
                         :alt="pizza.name"
                         :class="[
                            'rounded-lg transition mb-4 mx-auto',
                            selectedSize === 'small' && 'scale-75',
                            selectedSize === 'medium' && 'scale-90',
                            selectedSize === 'large' && 'scale-100'
                    ]"/>
                </div>
                <div class="flex flex-col p-8">
                    <div class="text-3xl font-bold dark:text-white">{{ pizza.name }}</div>
                    <div class="text-sm text-stone-400 mt-1.5">{{ sizeDescription }}</div>
                    <div class="flex justify-between p-1 mt-4 overflow-x-auto text-white bg-stone-700 rounded-2xl">
                        <button
                            v-for="size in sizes"
                            :key="size.key"
                            @click="selectSize(size.key)"
                            :class="[
                                'w-full px-6 py-2.5 rounded-2xl cursor-pointer transition-colors',
                                selectedSize === size.key ? 'bg-jaffa-400/30' : 'bg-transparent'
                            ]">
                            {{ size.label }}
                        </button>
                    </div>
                    <div class="flex justify-between p-1 mt-4 text-white bg-stone-700 rounded-2xl">
                        <button
                            v-for="crust in crusts"
                            :key="crust.key"
                            @click="selectCrust(crust.key)"
                            :class="['w-full px-6 py-2.5 rounded-2xl cursor-pointer transition-colors',
                                    selectedCrust === crust.key ? 'bg-jaffa-400/30' : 'bg-transparent']">
                            {{ crust.label }}
                        </button>
                    </div>
                    <div class="text-lg font-bold dark:text-white mt-4">Добавить по вкусу</div>
                    <div class="flex gap-x-2 mt-4">
                        <div v-for="item in addons"
                             :key="item.key"
                             @click="toggleAddon(item.label)"
                             :class="['flex flex-col relative overflow-hidden cursor-pointer p-3 border-2 rounded-2xl dark:bg-stone-700 transition',
                              selectedAddons.includes(item.label) ? 'border-jaffa-500' : 'border-stone-700']">
                            <img :src="item.image" :alt="item.label" class="pointer-events-none select-none">
                            <div class="mt-2 text-sm/4 dark:text-white text-pretty text-center">{{ item.label }}</div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-8 sm:mt-4">
                        <span class="text-xl font-bold dark:text-white">{{ calculatedPrice }} ₽</span>
                        <CommonButton
                            @click="addToCart"
                            margin-class="sm:mt-10"
                            width-class="w-max"
                        >
                            Добавить в корзину
                        </CommonButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

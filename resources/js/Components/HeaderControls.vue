<script setup>
import {computed, ref} from 'vue';
import {Link, usePage} from '@inertiajs/vue3';
import {useCartStore} from '@/Stores/cart.js';
import {useModalStore} from '@/Stores/modal.js';
import {useClickOutside} from '@/Composables/useClickOutside.js';

const cartStore = useCartStore();
const modalStore = useModalStore();
const page = usePage();

const showMenu = ref(false);
const menuRef = ref(null);
const inactivityTimer = ref(null);

const hiddenPages = ['/profile/orders', '/profile', '/order/create'];

const isHiddenPage = computed(() =>
    hiddenPages.some(path => page.url.startsWith(path))
);

const user = computed(() => {
    return typeof page.props?.auth?.user === 'object'
        ? page.props.auth.user
        : null
});

const isAuthenticated = computed(() => !!user.value);

// закрытие меню по бездействию
const resetInactivityTimer = () => {
    clearTimeout(inactivityTimer.value);
    if (showMenu.value) {
        inactivityTimer.value = setTimeout(() => {
            showMenu.value = false;
        }, 10000);
    }
};

useClickOutside(menuRef, () => {
    showMenu.value = false;
});
</script>

<template>
    <div v-if="isAuthenticated"
         ref="menuRef"
         class="relative inline-block">
        <button
            @click="showMenu = !showMenu"
            :class="['flex items-center gap-2 hover:text-white hover:bg-jaffa-500 border focus:ring-2 focus:outline-none focus:ring-jaffa-600 font-medium rounded-2xl px-5 py-2.5 text-center border-jaffa-500 text-jaffa-500 cursor-pointer', showMenu ? '' : '']">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="size-6 sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
            </svg>
            <span class="hidden sm:block">Профиль</span>
        </button>
        <ul v-if="showMenu"
            @mousemove="resetInactivityTimer"
            class="absolute mt-2.5 top-full w-max right-0 bg-neutral-800 text-white rounded-2xl border border-stone-700 overflow-hidden sm:w-full">
            <li class="hover:bg-jaffa-400/30 cursor-pointer">
                <Link href="/profile" class="inline-block px-5 pb-1 pt-2">Настройки</Link>
            </li>
            <li class="hover:bg-jaffa-400/30 cursor-pointer">
                <Link href="/profile/orders" class="inline-block px-5 py-1">Заказы</Link>
            </li>
            <li class="hover:bg-jaffa-400/30 cursor-pointer">
                <Link href="/logout" class="inline-block px-5 pt-1 pb-2">Выйти</Link>
            </li>
        </ul>
    </div>
    <button
        v-else
        @click="modalStore.openEmailAuth"
        class="border focus:ring-2 focus:outline-none font-medium rounded-2xl px-5 py-2.5 text-center border-jaffa-500 text-jaffa-500 hover:text-white hover:bg-jaffa-500 focus:ring-jaffa-900 cursor-pointer">
        Войти
    </button>
    <div
        v-if="!isHiddenPage"
        @click="cartStore.openDrawer"
        :class="['relative flex border focus:ring-2 focus:outline-none font-medium rounded-2xl px-5 py-2.5 text-center border-jaffa-500 text-jaffa-500 hover:text-white hover:bg-jaffa-500 focus:ring-jaffa-900 cursor-pointer', cartStore.items.length ? 'bg-jaffa-500 text-white px-3' : '']">
        <span v-if="cartStore.totalPrice" class="hidden pe-3 md:block">{{ cartStore.totalPrice + ' ₽' }}</span>
        <div :class="['flex', cartStore.items.length ? 'md:ps-3 md:border-white/25 md:border-l-1 ' : '']">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                 xmlns="http://www.w3.org/2000/svg"
                 class="size-5 transition">
                <path
                    d="M6.33333 16.3332C7.06971 16.3332 7.66667 15.7362 7.66667 14.9998C7.66667 14.2635 7.06971 13.6665 6.33333 13.6665C5.59695 13.6665 5 14.2635 5 14.9998C5 15.7362 5.59695 16.3332 6.33333 16.3332Z"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"/>
                <path
                    d="M14.3333 16.3332C15.0697 16.3332 15.6667 15.7362 15.6667 14.9998C15.6667 14.2635 15.0697 13.6665 14.3333 13.6665C13.597 13.6665 13 14.2635 13 14.9998C13 15.7362 13.597 16.3332 14.3333 16.3332Z"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"/>
                <path
                    d="M4.77984 4.99984H16.3332L15.2132 10.5932C15.1522 10.9001 14.9852 11.1758 14.7415 11.372C14.4977 11.5683 14.1927 11.6725 13.8798 11.6665H6.83317C6.50763 11.6693 6.19232 11.5528 5.94671 11.3391C5.70109 11.1255 5.54215 10.8293 5.49984 10.5065L4.4865 2.8265C4.44448 2.50599 4.28745 2.21167 4.04464 1.99828C3.80182 1.7849 3.48976 1.66699 3.1665 1.6665H1.6665"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round"/>
            </svg>
            <span
                v-if="cartStore.items.length"
                class="px-1.5">
                {{ cartStore.totalQuantity }}
            </span>
        </div>
    </div>
</template>


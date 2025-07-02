<script setup>
import {watchEffect} from 'vue';
import Header from '@/Components/Header.vue';
import Drawer from '@/Components/Drawer.vue';
import NotificationContainer from '@/Containers/NotificationContainer.vue';
import ModalContainer from '@/Containers/ModalContainer.vue';
import {useCartStore} from '@/Stores/cart.js';
import {useModalStore} from '@/Stores/modal.js';
import {useFlashMessage} from '@/Composables/useFlashMessage.js';

useFlashMessage();

const cartStore = useCartStore();
const modalStore = useModalStore();

// следим за открытыми элементами
watchEffect(() => {
    const anyOpen = modalStore.hasOpenModals || cartStore.drawerOpen;
    document.body.classList.toggle('overflow-hidden', anyOpen);
});

</script>

<template>
    <Header/>
    <Drawer v-if="cartStore.drawerOpen"/>
    <main>
        <slot/>
    </main>
    <NotificationContainer/>
    <ModalContainer/>
</template>


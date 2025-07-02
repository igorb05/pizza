<script setup>
import {Teleport} from 'vue';
import EmailAuthModal from '@/Components/EmailAuthModal.vue';
import VerificationCodeModal from '@/Components/VerificationCodeModal.vue';
import ProductDetailsModal from '@/Components/ProductDetailsModal.vue';
import {useModalStore} from '@/Stores/modal.js';

const modalStore = useModalStore();
</script>

<template>
    <Teleport to="body">
        <EmailAuthModal
            v-if="modalStore.showEmailAuth"
            @close="modalStore.closeEmailAuth"
            @entry-code="modalStore.openCode"
        />
        <VerificationCodeModal
            v-if="modalStore.showVerificationCode"
            :user-email="modalStore.userEmail"
            @close="modalStore.closeVerificationCode"
        />
        <ProductDetailsModal
            v-if="modalStore.showProductDetails"
            :product="modalStore.selectedProduct"
            @close="modalStore.closeProductDetails"
        />
    </Teleport>
</template>

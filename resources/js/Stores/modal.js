import {defineStore} from 'pinia';
import {ref, computed, readonly} from 'vue';

/**
 * Store для управления модальными окнами
 * Хранит состояния для их отображения
 */
export const useModalStore = defineStore('modal', () => {
    const showEmailAuth = ref(false);
    const showVerificationCode = ref(false);
    const showProductDetails = ref(false);
    const selectedProduct = ref(null);
    const userEmail = ref('');

    const hasOpenModals = computed(() =>
        showEmailAuth.value || showVerificationCode.value || showProductDetails.value
    );

    const openEmailAuth = () => {
        showEmailAuth.value = true;
    };

    const closeEmailAuth = () => {
        showEmailAuth.value = false;
    };

    const openVerificationCode = (email) => {
        userEmail.value = email;
        showEmailAuth.value = false;
        showVerificationCode.value = true;
    };

    const closeVerificationCode = () => {
        showVerificationCode.value = false;
        userEmail.value = '';
    };

    const openProductDetails = (product) => {
        selectedProduct.value = product;
        showProductDetails.value = true;
    };

    const closeProductDetails = () => {
        showProductDetails.value = false;
        selectedProduct.value = null;
    };

    return {
        showEmailAuth: readonly(showEmailAuth),
        showVerificationCode: readonly(showVerificationCode),
        userEmail: readonly(userEmail),
        showProductDetails: readonly(showProductDetails),
        selectedProduct: readonly(selectedProduct),
        hasOpenModals,
        openEmailAuth,
        closeEmailAuth,
        openVerificationCode,
        openProductDetails,
        closeProductDetails,
        closeVerificationCode
    };
});

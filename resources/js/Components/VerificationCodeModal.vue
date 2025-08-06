<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import {useModalStore} from '@/Stores/modal.js';
import {useClickOutside} from '@/Composables/useClickOutside.js';
import Input from '@/Components/FormInput.vue';
import CommonButton from '@/Components/CommonButton.vue';

const modalStore = useModalStore();
const codeRef = ref(null);

const form = useForm({
    email: modalStore.userEmail,
    code: '',
});

const loading = ref(false);
const verifyCode = () => {
    loading.value = true;

    form.post('/auth/verify-code', {
        onFinish: () => {
            loading.value = false
        },
    })
};

useClickOutside(codeRef, modalStore.closeVerificationCode, true);
</script>

<template>
    <div
        class="fixed inset-0 bg-stone-700/70 z-10 flex justify-center items-center">
        <div ref="codeRef" class="relative max-w-xs w-full bg-neutral-800 rounded-2xl px-11 py-12 sm:max-w-md">
            <button @click="modalStore.closeVerificationCode"
                    class="absolute top-2.5 right-5 z-10 text-3xl font-bold text-white cursor-pointer transition hover:text-jaffa-400 hover:scale-150 sm:top-0 sm:-right-8">
                ×
            </button>
            <div class="flex items-center">
                <div>
                    <div class="text-4xl text-white">Введите код</div>
                    <div class="text-stone-400 mt-2.5">Код был отправлен на электронную почту – <span
                        class="text-jaffa-400">{{ modalStore.userEmail }}</span>
                    </div>
                </div>
                <img src="/images/icons/code.png" class="w-16 h-16" alt="Code Icon">
            </div>

            <div class="mt-5">
                <form @submit.prevent="verifyCode">
                    <div class="flex gap-x-2 justify-center">
                        <Input type="text" id="code" v-model="form.code" placeholder="123456" inputmode="numeric" pattern="[0-9]*" maxlength="6" required/>
                        <div v-if="form.errors.code">{{ form.errors.code }}</div>
                    </div>
                    <CommonButton type="submit" margin-class="mt-5">
                        Войти
                    </CommonButton>
                </form>
            </div>
        </div>
    </div>
</template>
